<?php

// Carico l'autoloader di Composer
require __DIR__ . '/vendor/autoload.php';

// Importo le classi necessarie
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

// Configurazione per i log
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "=== TEST SCRAPER ITSALE.PL LIST PAGE ===\n\n";

// Funzione per salvare i log
function logInfo($message) {
    echo "[INFO] " . $message . "\n";
}

function logError($message) {
    echo "[ERROR] " . $message . "\n";
}

function saveHtml($html, $filename) {
    file_put_contents($filename, $html);
    echo "[INFO] Saved HTML to $filename\n";
}

try {
    // Inizializzo il client HTTP
    $client = new Client([
        'timeout' => 60,
        'verify' => false, // Disabilita la verifica SSL per test
    ]);
    
    // Fetch della pagina delle liste
    echo "Fetching list page...\n";
    $response = $client->get('https://itsale.pl/list');
    
    if ($response->getStatusCode() !== 200) {
        logError("Failed to fetch ITSale.pl list page: " . $response->getStatusCode());
        exit(1);
    }
    
    $html = (string) $response->getBody();
    saveHtml($html, 'itsale_list_test.html');
    
    echo "Response length: " . strlen($html) . " bytes\n";
    
    // Creo il crawler
    $crawler = new Crawler($html);
    
    // Estraggo alcuni elementi di base per verificare che la pagina sia valida
    echo "\n=== PAGE STRUCTURE ===\n";
    $title = $crawler->filter('title')->count() > 0 ? $crawler->filter('title')->text() : 'No title found';
    echo "Page title: $title\n";
    
    // Test delle sezioni di liste
    echo "\n=== LIST SECTIONS TEST ===\n";
    $listSections = $crawler->filter('h2');
    echo "Found " . $listSections->count() . " potential list section headers\n";
    
    // Mostra le intestazioni delle sezioni
    $listSections->each(function (Crawler $node, $i) {
        echo "Section $i: " . trim($node->text()) . "\n";
    });
    
    // Cerca le tabelle con le liste
    echo "\n=== LIST TABLES TEST ===\n";
    $tables = $crawler->filter('table');
    echo "Found " . $tables->count() . " tables\n";
    
    // Analizza le tabelle delle liste
    $listTableFound = false;
    $tables->each(function (Crawler $table, $tableIndex) use (&$listTableFound) {
        $rows = $table->filter('tr');
        if ($rows->count() > 1) { // Deve avere almeno una riga di intestazione e una di dati
            echo "\nTable $tableIndex has " . $rows->count() . " rows\n";
            
            // Controlla l'intestazione
            $headers = $table->filter('th, thead td');
            if ($headers->count() > 0) {
                $headerTexts = $headers->each(function ($node) {
                    return trim($node->text());
                });
                echo "Headers: " . implode(', ', $headerTexts) . "\n";
                
                // Se c'è un'intestazione con "Units" o "Average", è probabilmente una tabella di liste
                $isListTable = false;
                foreach ($headerTexts as $header) {
                    if (stripos($header, 'Units') !== false || stripos($header, 'Average') !== false) {
                        $isListTable = true;
                        break;
                    }
                }
                
                if ($isListTable) {
                    $listTableFound = true;
                    echo "This appears to be a list table!\n";
                    
                    // Analizza le righe di dati
                    $dataRows = $table->filter('tbody tr');
                    echo "Found " . $dataRows->count() . " data rows\n";
                    
                    // Mostra le prime 5 liste
                    $dataRows->each(function (Crawler $row, $i) use ($headerTexts) {
                        if ($i < 5) {
                            $cells = $row->filter('td');
                            
                            if ($cells->count() > 0) {
                                echo "\nList $i:\n";
                                
                                // Estrai unità e prezzo medio
                                $units = '';
                                $average = '';
                                $name = '';
                                $totalPrice = '';
                                
                                // Controlla se ci sono celle per Units e Average
                                $cells->each(function (Crawler $cell, $j) use (&$units, &$average, &$name, &$totalPrice, $headerTexts) {
                                    $cellText = trim($cell->text());
                                    $header = isset($headerTexts[$j]) ? $headerTexts[$j] : '';
                                    
                                    if (stripos($header, 'Units') !== false) {
                                        $units = $cellText;
                                    } elseif (stripos($header, 'Average') !== false) {
                                        $average = $cellText;
                                    } elseif (empty($name) && $cell->filter('a')->count() > 0) {
                                        $name = trim($cell->filter('a')->text());
                                    } elseif (preg_match('/^€[\d,.]+$/', $cellText)) {
                                        $totalPrice = $cellText;
                                    }
                                    
                                    echo "  " . ($header ?: "Column $j") . ": " . $cellText . "\n";
                                });
                                
                                // Se c'è un link, estrai l'URL
                                $links = $row->filter('a');
                                if ($links->count() > 0) {
                                    $href = $links->first()->attr('href');
                                    echo "  Link: " . $href . "\n";
                                    
                                    // Estrai lo slug dalla URL
                                    $slug = basename($href);
                                    echo "  Slug: " . $slug . "\n";
                                }
                                
                                // Costruisci il formato dati per lo scraper
                                if (!empty($name)) {
                                    echo "  Formatted data:\n";
                                    echo "  {\n";
                                    echo "    'id': '" . substr(md5($name), 0, 5) . "',\n";
                                    echo "    'slug': '" . (isset($slug) ? $slug : strtolower(str_replace(' ', '-', $name))) . "',\n";
                                    echo "    'name': '$name',\n";
                                    echo "    'units': " . (is_numeric($units) ? $units : "'" . $units . "'") . ",\n";
                                    echo "    'average_price': '$average',\n";
                                    echo "    'total_price': '$totalPrice'\n";
                                    echo "  }\n";
                                }
                            }
                        }
                    });
                }
            }
        }
    });
    
    if (!$listTableFound) {
        echo "No list tables found with expected structure\n";
        
        // Test alternativo: cerca liste mediante pattern di testo
        echo "\n=== ALTERNATIVE LIST DETECTION ===\n";
        $listMatches = [];
        $bodyText = $crawler->filter('body')->text();
        
        // Cerca pattern come "Units 60 Average €97.41"
        preg_match_all('/Units\s*(\d+)\s*Average\s*(€[\d,.]+)\s*([A-Za-z0-9\s]+)\s*\(([^)]+)\)\s*(€[\d,.]+)\s*(€[\d,.]+)/i', $bodyText, $matches, PREG_SET_ORDER);
        
        echo "Found " . count($matches) . " potential lists through text pattern\n";
        
        foreach ($matches as $i => $match) {
            if ($i < 5) {
                echo "\nList $i from text pattern:\n";
                echo "  Units: " . $match[1] . "\n";
                echo "  Average: " . $match[2] . "\n";
                echo "  Name: " . trim($match[3]) . "\n";
                echo "  Description: " . trim($match[4]) . "\n";
                echo "  Price: " . $match[5] . "\n";
                echo "  Discounted price: " . $match[6] . "\n";
                
                // Costruisci il formato dati per lo scraper
                $name = trim($match[3]);
                echo "  Formatted data:\n";
                echo "  {\n";
                echo "    'id': '" . substr(md5($name), 0, 5) . "',\n";
                echo "    'slug': '" . strtolower(str_replace(' ', '-', $name)) . "',\n";
                echo "    'name': '$name',\n";
                echo "    'units': " . $match[1] . ",\n";
                echo "    'average_price': '" . $match[2] . "',\n";
                echo "    'total_price': '" . $match[6] . "'\n";
                echo "  }\n";
            }
        }
    }
    
    // Test per trovare le categorie di liste
    echo "\n=== LIST CATEGORIES TEST ===\n";
    $categoryHeaders = $crawler->filter('h2, h3, h4');
    
    $categoryHeaders->each(function (Crawler $node, $i) use ($crawler) {
        $headerText = trim($node->text());
        if (!empty($headerText) && $headerText != "All Lists" && $headerText != "Latest Wholesale Lists") {
            echo "Category: $headerText\n";
            
            // Cerca la tabella più vicina dopo questo header
            $nextTable = $node->nextAll()->filter('table')->first();
            if ($nextTable->count() > 0) {
                $listRows = $nextTable->filter('tbody tr');
                echo "  Found " . $listRows->count() . " lists in this category\n";
            }
        }
    });
    
    echo "\n=== TEST COMPLETED SUCCESSFULLY ===\n";
    
} catch (\Exception $e) {
    echo "\n=== ERROR ===\n";
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
} 