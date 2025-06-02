<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThirdPartySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class ITSaleScraperController extends Controller
{
    /**
     * Display the ITSale.pl scraper interface with all lists.
     */
    public function index(ThirdPartySupplier $supplier = null)
    {
        // Se non viene passato un fornitore, cerchiamo quello di ITSale.pl
        if (!$supplier) {
            $supplier = ThirdPartySupplier::where('name', 'ITSale.pl')->first();
            
            // Se non troviamo un fornitore ITSale.pl nel database
            if (!$supplier) {
                return redirect()->route('admin.suppliers.index')
                    ->with('error', 'ITSale.pl supplier not found in the database. Please set up the supplier first.');
            }
        }
        
        // Check if this is actually ITSale.pl supplier
        if ($supplier->slug !== 'itsale-pl') {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'This scraper is only available for ITSale.pl');
        }
        
        try {
            // Fetch delle pagine richieste
            $listResponse = Http::timeout(60)->get('https://itsale.pl/list');
            $homepageResponse = Http::timeout(60)->get('https://itsale.pl/homepage.php?category_id=0&page=1&limit=60');
            
            // Debug info
            Log::info('ITSale scraper list response status: ' . $listResponse->status());
            Log::info('ITSale scraper homepage response status: ' . $homepageResponse->status());
            
            if (!$listResponse->successful() && !$homepageResponse->successful()) {
                Log::error('Failed to fetch ITSale.pl data');
                return view('admin.itsale.index', [
                    'supplier' => $supplier,
                    'latestLists' => [],
                    'allLists' => [],
                    'error' => 'Failed to fetch data from ITSale.pl.'
                ]);
            }
            
            // Inizializziamo le liste
            $allLists = [];
            $latestLists = [];
            
            // PARTE 1: Estrazione da https://itsale.pl/list (All Available Lists)
            if ($listResponse->successful()) {
                $html = $listResponse->body();
                
                // Save HTML for debugging
                file_put_contents(storage_path('logs/itsale_list.html'), $html);
                Log::info('Saved list HTML to logs/itsale_list.html for analysis');
                
                // Utilizziamo il crawler per estrarre le liste in modo strutturato
                $crawler = new Crawler($html);
                $listRows = $crawler->filter('.row');
                
                Log::info('Found ' . $listRows->count() . ' list rows in main list page');
                
                $listRows->each(function (Crawler $row) use (&$allLists) {
                    try {
                        // Estrai unità
                        $unitsNode = $row->filter('.units-average b')->first();
                        $units = $unitsNode->count() > 0 ? trim($unitsNode->text()) : '';
                
                        // Estrai prezzo medio
                        $avgPriceNode = $row->filter('.units-average b')->eq(1);
                        $avgPrice = $avgPriceNode->count() > 0 ? trim($avgPriceNode->text()) : '';
                        
                        // Estrai nome
                        $nameNode = $row->filter('.list-card-wrapper-link');
                        $name = $nameNode->count() > 0 ? trim($nameNode->text()) : '';
                        
                        // Estrai descrizione
                        $descNode = $row->filter('.list-description');
                        $description = $descNode->count() > 0 ? trim($descNode->text()) : '';
                        
                        // Estrai prezzo vecchio (non scontato)
                        $oldPriceNode = $row->filter('.old-price');
                        $oldPrice = $oldPriceNode->count() > 0 ? trim($oldPriceNode->text()) : '';
                        
                        // Estrai prezzo finale (scontato)
                        $finalPriceNode = $row->filter('.list-price');
                        $finalPrice = '';
                        if ($finalPriceNode->count() > 0) {
                            // Raccoglie tutte le parti del prezzo
                            $finalPrice = $finalPriceNode->text();
                            $finalPrice = preg_replace('/\s+/', '', $finalPrice);
                        }
                        
                        if (!empty($name)) {
                            $list = [
                                'units' => $units,
                                'average_price' => $avgPrice,
                                'name' => $name,
                                'description' => $description,
                                'price' => $finalPrice,
                                'discounted_price' => $oldPrice
                            ];
                            
                            $allLists[] = $list;
                }
                    } catch (\Exception $e) {
                        Log::error('Error extracting list data: ' . $e->getMessage());
                    }
                });
                
                // Se non abbiamo trovato liste con il nuovo metodo, usa i metodi precedenti come fallback
                if (empty($allLists)) {
                    // Estrazione dei dati dal testo completo
                    $bodyText = preg_replace('/\s+/', ' ', $html); // Normalizza gli spazi
                    $bodyText = strip_tags($bodyText); // Rimuovi tutti i tag HTML
                    
                    // Metodo 1: cerca pattern di lista con Units e Average
                    if (preg_match_all('/Units\s*(\d+)\s*Average\s*(?:€|&euro;)?([\d,.]+)([^(]*)\(([^)]+)\)(?:[^€]*(?:€|&euro;)([\d,.]+))?(?:[^€]*(?:€|&euro;)([\d,.]+))?/i', $bodyText, $matches, PREG_SET_ORDER)) {
                        Log::info('Found ' . count($matches) . ' lists with method 1 from /list');
                        
                        foreach ($matches as $match) {
                            $name = trim($match[3]);
                            // Pulisci il nome rimuovendo prefissi e prezzi
                            $name = preg_replace('/^(?:Mix\s*)?Units\s*\d+\s*Average\s*(?:€|&euro;)?[\d,.]+\s*/i', '', $name);
                            // Rimuovi anche i prezzi alla fine del nome (pattern più robusto)
                            $name = preg_replace('/\s+(?:€|&euro;)[\d,.]+(?:\s+(?:€|&euro;)[\d,.]+)?$/i', '', $name);
                            // Elimina qualsiasi sequenza di prezzi o numeri alla fine del nome
                            $name = preg_replace('/\s+[\d,.]+(?:\s+[\d,.]+)*$/i', '', $name);
                            
                            $list = [
                                'units' => $match[1],
                                'average_price' => '€' . $match[2],
                                'name' => $name,
                                'description' => trim($match[4]),
                                'price' => isset($match[6]) ? '€' . $match[6] : (isset($match[5]) ? '€' . $match[5] : ''),
                                'discounted_price' => isset($match[5]) ? '€' . $match[5] : ''
                            ];
                            
                            $allLists[] = $list;
                        }
                    }
                }
            }
            
            // PARTE 2: Estrazione da https://itsale.pl/homepage.php (Latest Wholesale Lists)
            if ($homepageResponse->successful()) {
                $html = $homepageResponse->body();
                
                // Save HTML for debugging
                file_put_contents(storage_path('logs/itsale_homepage.html'), $html);
                Log::info('Saved homepage HTML to logs/itsale_homepage.html for analysis');
                
                $crawler = new Crawler($html);
                
                // Cerca il div con id "lists"
                $listsDiv = $crawler->filter('#lists');
                
                if ($listsDiv->count() > 0) {
                    Log::info('Found #lists div in homepage');
                    
                    // Estrazione strutturata dalle liste HTML
                    $listRows = $listsDiv->filter('.row');
                    
                    if ($listRows->count() > 0) {
                        Log::info('Found ' . $listRows->count() . ' list rows in homepage');
                        
                        $listRows->each(function (Crawler $row) use (&$latestLists) {
                            try {
                                // Estrai unità
                                $unitsNode = $row->filter('.units-average b')->first();
                                $units = $unitsNode->count() > 0 ? trim($unitsNode->text()) : '';
                                
                                // Estrai prezzo medio
                                $avgPriceNode = $row->filter('.units-average b')->eq(1);
                                $avgPrice = $avgPriceNode->count() > 0 ? trim($avgPriceNode->text()) : '';
                                
                                // Estrai nome
                                $nameNode = $row->filter('.list-card-wrapper-link');
                                $name = $nameNode->count() > 0 ? trim($nameNode->text()) : '';
                                
                                // Estrai descrizione
                                $descNode = $row->filter('.list-description');
                                $description = $descNode->count() > 0 ? trim($descNode->text()) : '';
                                
                                // Estrai prezzo vecchio (scontato)
                                $oldPriceNode = $row->filter('.old-price');
                                $oldPrice = $oldPriceNode->count() > 0 ? trim($oldPriceNode->text()) : '';
                    
                                // Estrai prezzo finale
                                $finalPriceNode = $row->filter('.list-price');
                                $finalPrice = '';
                                if ($finalPriceNode->count() > 0) {
                                    // Raccoglie tutte le parti del prezzo
                                    $finalPrice = $finalPriceNode->text();
                                    $finalPrice = preg_replace('/\s+/', '', $finalPrice);
                                }
                                
                                if (!empty($name)) {
                    $list = [
                                        'units' => $units,
                                        'average_price' => $avgPrice,
                        'name' => $name,
                        'description' => $description,
                                        'price' => $finalPrice,
                                        'discounted_price' => $oldPrice
                    ];
                    
                    $latestLists[] = $list;
                                }
                            } catch (\Exception $e) {
                                Log::error('Error extracting list data: ' . $e->getMessage());
                                }
                        });
                            }
                        }
                    }
                    
            // Elimina duplicati basati sul nome
            $uniqueAllLists = [];
            $processedNames = [];
            
            foreach ($allLists as $list) {
                $name = trim($list['name']);
                if (!in_array($name, $processedNames) && !empty($name)) {
                    $processedNames[] = $name;
                    $uniqueAllLists[] = $list;
                            }
                        }
            
            $allLists = $uniqueAllLists;
            Log::info('Final all lists count after removing duplicates: ' . count($allLists));
            
            // Se non abbiamo trovato latest lists, usa le prime 5 da all lists
            if (empty($latestLists)) {
                $latestLists = array_slice($allLists, 0, 5);
            } else {
                Log::info('Found ' . count($latestLists) . ' latest lists from homepage');
            }
                
                if (empty($latestLists) && empty($allLists)) {
                    // Nessuna lista trovata
                    Log::error('No lists found, check HTML structure');
                    
                    return view('admin.itsale.index', [
                        'supplier' => $supplier,
                        'latestLists' => [],
                        'allLists' => [],
                        'error' => 'No lists found. The website structure might have changed.'
                    ]);
                }
                
                return view('admin.itsale.index', compact('supplier', 'latestLists', 'allLists'));
        } catch (\Exception $e) {
            Log::error('Exception while scraping ITSale.pl: ' . $e->getMessage());
            return view('admin.itsale.index', [
                'supplier' => $supplier,
                'latestLists' => [],
                'allLists' => [],
                'error' => 'An error occurred while fetching data: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Display details of a specific list from ITSale.pl.
     */
    public function showList(ThirdPartySupplier $supplier = null, $listSlug)
    {
        // Se non viene passato un fornitore, cerchiamo quello di ITSale.pl
        if (!$supplier) {
            $supplier = ThirdPartySupplier::where('name', 'ITSale.pl')->first();
            
            // Se non troviamo un fornitore ITSale.pl nel database
            if (!$supplier) {
                return redirect()->route('admin.suppliers.index')
                    ->with('error', 'ITSale.pl supplier not found in the database. Please set up the supplier first.');
            }
        }
        
        // Check if this is actually ITSale.pl supplier
        if ($supplier->slug !== 'itsale-pl') {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'This scraper is only available for ITSale.pl');
        }

        try {
            // Check if we're forcing a refresh
            $forceRefresh = request()->has('refresh');
            
            if ($forceRefresh) {
                Log::info('Force refreshing data for list: ' . $listSlug);
            }
            
            // Fetch della pagina delle liste
            $response = Http::timeout(60)->get('https://itsale.pl/list');
            
            if (!$response->successful()) {
                Log::error('Failed to fetch ITSale.pl lists: ' . $response->status());
                
                // Fallback: prova con la homepage prima di fallire completamente
                $homepageResponse = Http::timeout(60)->get('https://itsale.pl/homepage.php?category_id=0&page=1&limit=60');
                
                if (!$homepageResponse->successful()) {
                    // Entrambi i tentativi sono falliti
                return redirect()->route('admin.itsale.index', $supplier)
                        ->with('error', 'Failed to fetch data from ITSale.pl. Status codes: list=' . $response->status() . ', homepage=' . $homepageResponse->status());
            }
            
                // Continua con i dati della homepage
                $html = $homepageResponse->body();
                Log::info('Using homepage data as fallback');
            } else {
            $html = $response->body();
            }
            
            // Salviamo l'HTML per debug
            file_put_contents(storage_path('logs/itsale_list_page.html'), $html);
            Log::info('Saved list page HTML for analysis');
            
            // Inizializziamo le liste
            $lists = [];
            
            // Utilizziamo il crawler per estrarre le liste in modo strutturato
            $crawler = new Crawler($html);
            $listRows = $crawler->filter('.row');
            
            Log::info('Found ' . $listRows->count() . ' list rows');
            
            $listRows->each(function (Crawler $row) use (&$lists) {
                try {
                    // Estrai unità
                    $unitsNode = $row->filter('.units-average b')->first();
                    $units = $unitsNode->count() > 0 ? trim($unitsNode->text()) : '';
                    
                    // Estrai prezzo medio
                    $avgPriceNode = $row->filter('.units-average b')->eq(1);
                    $avgPrice = $avgPriceNode->count() > 0 ? trim($avgPriceNode->text()) : '';
                    
                    // Estrai nome
                    $nameNode = $row->filter('.list-card-wrapper-link');
                    $name = $nameNode->count() > 0 ? trim($nameNode->text()) : '';
            
                    // Estrai descrizione
                    $descNode = $row->filter('.list-description');
                    $description = $descNode->count() > 0 ? trim($descNode->text()) : '';
                    
                    // Estrai prezzo vecchio (non scontato)
                    $oldPriceNode = $row->filter('.old-price');
                    $oldPrice = $oldPriceNode->count() > 0 ? trim($oldPriceNode->text()) : '';
                    
                    // Estrai prezzo finale (scontato)
                    $finalPriceNode = $row->filter('.list-price');
                    $finalPrice = '';
                    if ($finalPriceNode->count() > 0) {
                        // Raccoglie tutte le parti del prezzo
                        $finalPrice = $finalPriceNode->text();
                        $finalPrice = preg_replace('/\s+/', '', $finalPrice);
                    }
                    
                    if (!empty($name)) {
                        $currSlug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
                        
                        $lists[$currSlug] = [
                            'name' => $name,
                            'description' => $description,
                            'units' => (int)$units,
                            'avg_price' => $avgPrice,
                            'total_price' => $finalPrice
                        ];
                    }
                } catch (\Exception $e) {
                    Log::error('Error extracting list data: ' . $e->getMessage());
                }
            });
            
            // Se non abbiamo trovato liste con il nuovo metodo, usiamo i metodi precedenti come fallback
            if (empty($lists)) {
                // Estrazione dei dati dal testo completo
                $bodyText = preg_replace('/\s+/', ' ', $html); // Normalizza gli spazi
                $bodyText = strip_tags($bodyText); // Rimuovi tutti i tag HTML
                
                // Metodo 1: cerca pattern di lista con Units e Average
                if (preg_match_all('/Units\s*(\d+)\s*Average\s*(?:€|&euro;)?([\d,.]+)([^(]*)\(([^)]+)\)(?:[^€]*(?:€|&euro;)([\d,.]+))?(?:[^€]*(?:€|&euro;)([\d,.]+))?/i', $bodyText, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                $name = trim($match[3]);
                        // Pulisci il nome rimuovendo prefissi e prezzi
                        $name = preg_replace('/^(?:Mix\s*)?Units\s*\d+\s*Average\s*(?:€|&euro;)?[\d,.]+\s*/i', '', $name);
                        // Rimuovi anche i prezzi alla fine del nome (pattern più robusto)
                        $name = preg_replace('/\s+(?:€|&euro;)[\d,.]+(?:\s+(?:€|&euro;)[\d,.]+)?$/i', '', $name);
                        // Elimina qualsiasi sequenza di prezzi o numeri alla fine del nome
                        $name = preg_replace('/\s+[\d,.]+(?:\s+[\d,.]+)*$/i', '', $name);
                $currSlug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
                
                        $lists[$currSlug] = [
                            'name' => $name,
                            'description' => trim($match[4]),
                            'units' => (int)$match[1],
                            'avg_price' => '€' . $match[2],
                            'total_price' => isset($match[6]) ? '€' . $match[6] : (isset($match[5]) ? '€' . $match[5] : '')
                        ];
                    }
                }
                
                // Metodo 2: cerca pattern alternativo (Mix Units...)
                if (preg_match_all('/Mix\s*Units\s*(\d+)\s*Average\s*(?:€|&euro;)?([\d,.]+)([^(]*)\(([^)]+)\)(?:[^€]*(?:€|&euro;)([\d,.]+))?(?:[^€]*(?:€|&euro;)([\d,.]+))?/i', $bodyText, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        $name = trim($match[3]);
                        // Pulisci il nome rimuovendo prefissi e prezzi
                        $name = preg_replace('/^(?:Mix\s*)?Units\s*\d+\s*Average\s*(?:€|&euro;)?[\d,.]+\s*/i', '', $name);
                        // Rimuovi anche i prezzi alla fine del nome (pattern più robusto)
                        $name = preg_replace('/\s+(?:€|&euro;)[\d,.]+(?:\s+(?:€|&euro;)[\d,.]+)?$/i', '', $name);
                        // Elimina qualsiasi sequenza di prezzi o numeri alla fine del nome
                        $name = preg_replace('/\s+[\d,.]+(?:\s+[\d,.]+)*$/i', '', $name);
                        $currSlug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
                        
                        $lists[$currSlug] = [
                        'name' => $name,
                        'description' => trim($match[4]),
                        'units' => (int)$match[1],
                            'avg_price' => '€' . $match[2],
                            'total_price' => isset($match[6]) ? '€' . $match[6] : (isset($match[5]) ? '€' . $match[5] : '')
                    ];
                    }
                }
                
                // Metodo 3: Dividi in righe e cerca righe che contengono sia "Units" che "Average"
                $lines = explode("\n", strip_tags($html));
                
                foreach ($lines as $line) {
                    $line = preg_replace('/\s+/', ' ', $line); // Normalizza gli spazi
                    
                    if (strpos($line, 'Units') !== false && strpos($line, 'Average') !== false) {
                        // Estrai Units
                        $units = '';
                        if (preg_match('/Units\s*(\d+)/i', $line, $unitMatches)) {
                            $units = $unitMatches[1];
                        }
                        
                        // Estrai Average
                        $avgPrice = '';
                        if (preg_match('/Average\s*(?:€|&euro;)?([\d,.]+)/i', $line, $avgMatches)) {
                            $avgPrice = '€' . $avgMatches[1];
                        }
                        
                        // Estrai name e description
                        $name = '';
                        $description = '';
                        if (preg_match('/Average[^(]*([^(]+)\(([^)]+)\)/i', $line, $descMatches)) {
                            $name = trim($descMatches[1]);
                            // Pulisci il nome rimuovendo prefissi
                            $name = preg_replace('/^(?:Mix\s*)?Units\s*\d+\s*Average\s*(?:€|&euro;)?[\d,.]+\s*/i', '', $name);
                            // Rimuovi anche i prezzi alla fine del nome (pattern più robusto)
                            $name = preg_replace('/\s+(?:€|&euro;)[\d,.]+(?:\s+(?:€|&euro;)[\d,.]+)?$/i', '', $name);
                            // Elimina qualsiasi sequenza di prezzi o numeri alla fine del nome
                            $name = preg_replace('/\s+[\d,.]+(?:\s+[\d,.]+)*$/i', '', $name);
                            $description = trim($descMatches[2]);
                }
                        
                        // Estrai prezzi
                        $prices = [];
                        if (preg_match_all('/(?:€|&euro;)([\d,.]+)/i', $line, $priceMatches)) {
                            $prices = $priceMatches[1];
            }
            
                        if (!empty($units) && !empty($name)) {
                            $currSlug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
                            
                            $lists[$currSlug] = [
                                'name' => $name,
                                'description' => $description,
                                'units' => (int)$units,
                                'avg_price' => $avgPrice,
                                'total_price' => isset($prices[1]) ? '€' . $prices[1] : (isset($prices[0]) ? '€' . $prices[0] : '')
                            ];
                        }
                    }
                }
            }
            
            if (!isset($lists[$listSlug])) {
                Log::error('List not found: ' . $listSlug);
                return redirect()->route('admin.itsale.index', $supplier)
                    ->with('error', 'List not found: ' . $listSlug);
            }
            
            $foundList = $lists[$listSlug];
            
            // Assicuriamoci che la lista abbia il campo discounted_price
            if (!isset($foundList['discounted_price'])) {
                $foundList['discounted_price'] = '';
                
                // Cerca il prezzo originale nell'HTML
                $crawler = new Crawler($html);
                $oldPriceNode = $crawler->filter('.old-price');
                if ($oldPriceNode->count() > 0) {
                    $foundList['discounted_price'] = trim($oldPriceNode->text());
                }
            }
            
            // Cerca il link per i dettagli
            $crawler = new Crawler($html);
            
            // Prova a trovare link che contengano il nome della lista
            $listLink = null;
            $crawler->filter('a')->each(function (Crawler $node) use ($foundList, &$listLink) {
                if (stripos($node->text(), $foundList['name']) !== false) {
                    $listLink = $node->attr('href');
                }
            });
            
            // Se non abbiamo trovato un link, costruiamolo direttamente dallo slug
            if (!$listLink) {
                $listLink = 'https://itsale.pl/list/' . $listSlug;
                Log::info('No direct link found, using constructed URL: ' . $listLink);
            }
            
            $items = [];
            
            // Abbiamo trovato un link alla lista, facciamo scraping della pagina dettaglio
            // Assicuriamoci che l'URL sia completo
            if (!str_starts_with($listLink, 'http')) {
                $listLink = 'https://itsale.pl/' . ltrim($listLink, '/');
            }
            
            Log::info('Fetching list details from URL: ' . $listLink);
            
            // If force refresh is enabled, add a cache-busting parameter
            if ($forceRefresh) {
                $listLink .= (parse_url($listLink, PHP_URL_QUERY) ? '&' : '?') . 'refresh=' . time();
                Log::info('Added cache-busting parameter to URL: ' . $listLink);
            }
            
            $listResponse = Http::timeout(60)->get($listLink);
            
            if ($listResponse->successful()) {
                $listHtml = $listResponse->body();
                file_put_contents(storage_path('logs/itsale_list_detail_' . $listSlug . '.html'), $listHtml);
                
                $listCrawler = new Crawler($listHtml);
                
                // Log HTML structure for debugging
                Log::info('Analyzing HTML structure for list: ' . $listSlug);
                
                // Cerca la tabella dei prodotti
                $table = $listCrawler->filter('table');
                
                if ($table->count() > 0) {
                    Log::info('Found ' . $table->count() . ' tables in the page');
                    
                    $headers = $table->filter('th')->each(function ($node) {
                        return trim($node->text());
                    });
                    
                    Log::info('Table headers: ' . json_encode($headers));
                    
                    $rows = $table->filter('tbody tr');
                    Log::info('Found ' . $rows->count() . ' rows in the table');
                    
                    $rows->each(function (Crawler $row) use (&$items, $headers) {
                        $cells = $row->filter('td');
                        
                        if ($cells->count() > 0) {
                            $item = [];
                            
                            for ($i = 0; $i < min($cells->count(), count($headers)); $i++) {
                                $key = strtolower(str_replace(' ', '_', $headers[$i]));
                                $value = trim($cells->eq($i)->text());
                                $item[$key] = $value;
                            }
                            
                            // Process the item to extract standard fields
                            $processedItem = $this->processItemData($item, $headers);
                            if (!empty($processedItem)) {
                                $items[] = $processedItem;
                            }
                        }
                    });
                }
                
                // If no items found in tables, try alternative selectors
                if (empty($items)) {
                    Log::info('No items found in tables, trying alternative selectors');
                    
                    // Try to find products in product-item divs
                    $productItems = $listCrawler->filter('.product-item, .item, .product');
                    Log::info('Found ' . $productItems->count() . ' product items using alternative selectors');
                    
                    if ($productItems->count() > 0) {
                        $productItems->each(function (Crawler $node) use (&$items) {
                            $item = [];
                            
                            // Extract title/model
                            $titleNode = $node->filter('.title, .product-title, h3, h4');
                            if ($titleNode->count() > 0) {
                                $item['model'] = trim($titleNode->text());
                                $item['name'] = $item['model'];
                            }
                            
                            // Extract specifications
                            $specNodes = $node->filter('.specs li, .specifications li, .properties li, .details li, p');
                            if ($specNodes->count() > 0) {
                                $specNodes->each(function (Crawler $specNode) use (&$item) {
                                    $text = trim($specNode->text());
                                    
                                    // Try to extract key-value pairs
                                    if (preg_match('/^([^:]+):\s*(.+)$/', $text, $matches)) {
                                        $key = strtolower(trim(str_replace(' ', '_', $matches[1])));
                                        $value = trim($matches[2]);
                                        $item[$key] = $value;
                                    } else {
                                        // Add as general info if not a key-value pair
                                        if (!isset($item['info'])) {
                                            $item['info'] = '';
                                        }
                                        $item['info'] .= $text . '; ';
                                    }
                                });
                            }
                            
                            // Process the item to extract standard fields
                            $processedItem = $this->processItemData($item, []);
                            if (!empty($processedItem)) {
                                $items[] = $processedItem;
                            }
                        });
                    }
                }
                
                // Even if we couldn't find items, log the HTML structure for debugging
                if (empty($items)) {
                    Log::warning('No items found for list: ' . $listSlug . '. Saving detailed HTML structure.');
                    
                    // Save a more detailed log with HTML structure
                    $htmlStructure = [];
                    $listCrawler->filter('body *')->each(function (Crawler $node) use (&$htmlStructure) {
                        $tagName = $node->nodeName();
                        $classes = $node->attr('class') ? explode(' ', $node->attr('class')) : [];
                        $id = $node->attr('id');
                        
                        if ($id || !empty($classes)) {
                            $htmlStructure[] = $tagName . 
                                ($id ? '#'.$id : '') . 
                                (!empty($classes) ? '.' . implode('.', $classes) : '');
                        }
                    });
                    
                    file_put_contents(
                        storage_path('logs/itsale_list_structure_' . $listSlug . '.txt'), 
                        implode("\n", $htmlStructure)
                    );
                }
            } else {
            // Errore nel recupero dei dettagli della lista
            Log::error('Failed to fetch list details: ' . $listResponse->status() . ' for URL ' . $listLink);
            // Continuiamo senza dettagli della lista
        }
        
        // Calcola statistiche per Visual Grade e Tech Grade
        $visualGradeStats = [
            'New' => '0%',
            'A' => '0%',
            'B' => '0%', 
            'C' => '0%',
            'D' => '0%',
            'Undefined' => '0%'
        ];
        
        $techGradeStats = [
            'New' => '0%',
            'Working' => '0%',
            'Working*' => '0%',
            'Not working' => '0%',
            'Undefined' => '0%'
        ];
        
        // Prova a estrarre statistiche direttamente dalla pagina dettaglio
        if ($listResponse->successful()) {
            $listCrawler = new Crawler($listHtml);
            
            // Estrai Visual Grade dalle statistiche
            $boxStats = $listCrawler->filter('.box_stat');
            $visualGradeBox = null;
            
            // Cerca il box Visual Grade
            $boxStats->each(function (Crawler $node) use (&$visualGradeBox) {
                if ($visualGradeBox === null && stripos($node->text(), 'Visual grade') !== false) {
                    $visualGradeBox = $node;
                }
            });
            
            if ($visualGradeBox !== null) {
                Log::info('Found Visual Grade stats box in the HTML');
                
                // Trova tutte le coppie di content e sub_content
                $contents = $visualGradeBox->filter('.box_stat_content');
                $subContents = $visualGradeBox->filter('.box_stat_sub_content');
                
                for ($i = 0; $i < $contents->count(); $i++) {
                    $grade = trim($contents->eq($i)->text());
                    $stat = trim($subContents->eq($i)->text());
            
                    // Aggiorna le statistiche solo se il grado è valido
                    if (isset($visualGradeStats[$grade])) {
                        $visualGradeStats[$grade] = $stat;
                    }
                }
            }
            
            // Estrai Tech Grade dalle statistiche
            $techGradeBox = null;
            
            // Cerca il box Tech Grade
            $boxStats->each(function (Crawler $node) use (&$techGradeBox) {
                if ($techGradeBox === null && stripos($node->text(), 'Tech grade') !== false) {
                    $techGradeBox = $node;
                }
            });
            
            if ($techGradeBox !== null) {
                Log::info('Found Tech Grade stats box in the HTML');
                
                // Trova tutte le coppie di content e sub_content
                $contents = $techGradeBox->filter('.box_stat_content');
                $subContents = $techGradeBox->filter('.box_stat_sub_content');
                
                for ($i = 0; $i < $contents->count(); $i++) {
                    $grade = trim($contents->eq($i)->text());
                    $stat = trim($subContents->eq($i)->text());
                    
                    // Aggiorna le statistiche solo se il grado è valido
                    if (isset($techGradeStats[$grade])) {
                        $techGradeStats[$grade] = $stat;
                    }
                }
            }
        }
        
        $totalItems = count($items);
        
        // Se non abbiamo trovato statistiche direttamente, calcoliamole dagli items
        if ($totalItems > 0 && $visualGradeStats['A'] === '0%' && $visualGradeStats['B'] === '0%' && $visualGradeStats['C'] === '0%') {
            $visualGrades = [];
            $techGrades = [];
            
            foreach ($items as $item) {
                // Estrai visual grade
                $visualGrade = 'Undefined';
                if (isset($item['visual_grade'])) {
                    $visualGrade = $item['visual_grade'];
                } elseif (isset($item['grade'])) {
                    if (preg_match('/Visual\s+grade:\s*([A-Z])/i', $item['grade'], $matches)) {
                        $visualGrade = strtoupper($matches[1]);
                    } elseif (preg_match('/Grade\s+([A-Z])/i', $item['grade'], $matches)) {
                        $visualGrade = strtoupper($matches[1]);
                    }
                }
                
                if (!isset($visualGrades[$visualGrade])) {
                    $visualGrades[$visualGrade] = 0;
                }
                $visualGrades[$visualGrade]++;
                
                // Estrai tech grade
                $techGrade = 'Undefined';
                if (isset($item['functionality'])) {
                    $techGrade = $item['functionality'];
                } elseif (isset($item['grade'])) {
                    if (preg_match('/Functionality:\s+([^"\n]+)/i', $item['grade'], $matches)) {
                        $techGrade = trim($matches[1]);
                    }
                }
                
                if (!isset($techGrades[$techGrade])) {
                    $techGrades[$techGrade] = 0;
                }
                $techGrades[$techGrade]++;
            }
        
            // Calcola percentuali per visual grades
            foreach ($visualGrades as $grade => $count) {
                $percentage = round(($count / $totalItems) * 100, 2);
                if (isset($visualGradeStats[$grade])) {
                    $visualGradeStats[$grade] = $percentage . '% (' . $count . ')';
                }
            }
            
            // Calcola percentuali per tech grades
            foreach ($techGrades as $grade => $count) {
                $percentage = round(($count / $totalItems) * 100, 2);
                if (isset($techGradeStats[$grade])) {
                    $techGradeStats[$grade] = $percentage . '% (' . $count . ')';
                }
            }
        }
        
        $listDetails = array_merge($foundList, [
            'items' => $items,
            'visual_grade' => $visualGradeStats,
            'tech_grade' => $techGradeStats
        ]);
        
        return view('admin.itsale.show-list', compact('supplier', 'listDetails', 'listSlug'));
        
    } catch (\Exception $e) {
        Log::error('Exception while scraping ITSale.pl list details: ' . $e->getMessage());
        return redirect()->route('admin.itsale.index', $supplier)
            ->with('error', 'An error occurred while fetching list details: ' . $e->getMessage());
    }
}

    /**
     * Display the import form for mapping fields.
     */
    public function showImportForm(Request $request, ThirdPartySupplier $supplier = null, $listSlug)
    {
        // Se non viene passato un fornitore, cerchiamo quello di ITSale.pl
        if (!$supplier) {
            $supplier = ThirdPartySupplier::where('name', 'ITSale.pl')->first();
            
            // Se non troviamo un fornitore ITSale.pl nel database
            if (!$supplier) {
                return redirect()->route('admin.suppliers.index')
                    ->with('error', 'ITSale.pl supplier not found in the database. Please set up the supplier first.');
            }
        }
        
        // Check if this is actually ITSale.pl supplier
        if ($supplier->slug !== 'itsale-pl') {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'This scraper is only available for ITSale.pl');
        }

        try {
            // Recuperiamo i dettagli della lista
            $response = Http::timeout(60)->get('https://itsale.pl/list');
            
            if (!$response->successful()) {
                return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                    ->with('error', 'Failed to fetch list details from ITSale.pl');
            }
            
            $html = $response->body();
            
            // Inizializziamo le liste
            $lists = [];
            
            // Utilizziamo il crawler per estrarre le liste in modo strutturato
            $crawler = new Crawler($html);
            $listRows = $crawler->filter('.row');
            
            // Estrai i dettagli di tutte le liste per trovare quella corretta
            $listRows->each(function (Crawler $row) use (&$lists, $listSlug) {
                try {
                    // Estrai nome
                    $nameNode = $row->filter('.list-card-wrapper-link');
                    if ($nameNode->count() > 0) {
                        $name = trim($nameNode->text());
                        $currSlug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
                        
                        // Se questa è la lista che cerchiamo, estrai tutti i dettagli
                        if ($currSlug === $listSlug) {
                            // Estrai unità
                            $unitsNode = $row->filter('.units-average b')->first();
                            $units = $unitsNode->count() > 0 ? trim($unitsNode->text()) : '';
                            
                            // Estrai prezzo medio
                            $avgPriceNode = $row->filter('.units-average b')->eq(1);
                            $avgPrice = $avgPriceNode->count() > 0 ? trim($avgPriceNode->text()) : '';
                            
                            // Estrai descrizione
                            $descNode = $row->filter('.list-description');
                            $description = $descNode->count() > 0 ? trim($descNode->text()) : '';
                            
                            // Estrai prezzo finale (scontato)
                            $finalPriceNode = $row->filter('.list-price');
                            $finalPrice = '';
                            if ($finalPriceNode->count() > 0) {
                                $finalPrice = $finalPriceNode->text();
                                $finalPrice = preg_replace('/\s+/', '', $finalPrice);
                            }
                            
                            $lists[$currSlug] = [
                                'name' => $name,
                                'description' => $description,
                                'units' => (int)preg_replace('/[^0-9]/', '', $units),
                                'avg_price' => $avgPrice,
                                'total_price' => $finalPrice,
                                'slug' => $currSlug
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error extracting list data for import form: ' . $e->getMessage());
                }
            });
            
            // Se non abbiamo trovato la lista, ritorniamo un errore
            if (!isset($lists[$listSlug])) {
                return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                    ->with('error', 'List not found in ITSale.pl data');
            }
            
            $listDetails = $lists[$listSlug];
            
            // Ora che abbiamo i dettagli della lista, carichiamo i dati dei prodotti
            $productsUrl = "https://itsale.pl/list/{$listSlug}";
            $productsResponse = Http::timeout(60)->get($productsUrl);
            
            if (!$productsResponse->successful()) {
                return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                    ->with('error', 'Failed to fetch products data from ITSale.pl');
            }
            
            $productsHtml = $productsResponse->body();
            $productsCrawler = new Crawler($productsHtml);
            
            // Estrai i prodotti dalla pagina
            $products = [];
            $productRows = $productsCrawler->filter('.product-list-item');
            
            // Debug info
            Log::info('Import form - Found ' . $productRows->count() . ' product rows using .product-list-item selector');
            
            // Try alternative selectors if no products found
            if ($productRows->count() == 0) {
                Log::info('Import form - Trying alternative selector: tr.product-row');
                $productRows = $productsCrawler->filter('tr.product-row');
                Log::info('Import form - Found ' . $productRows->count() . ' product rows using tr.product-row selector');
                
                if ($productRows->count() == 0) {
                    Log::info('Import form - Trying another selector: .product');
                    $productRows = $productsCrawler->filter('.product');
                    Log::info('Import form - Found ' . $productRows->count() . ' product rows using .product selector');
                    
                    // If still no products, try processing tables directly
                    if ($productRows->count() == 0) {
                        Log::info('Import form - Trying to process tables directly');
                        $tables = $productsCrawler->filter('table');
                        Log::info('Import form - Found ' . $tables->count() . ' tables in the page');
                        
                        if ($tables->count() > 0) {
                            // Process the first table with data
                            $tableRows = $tables->first()->filter('tr');
                            Log::info('Import form - Found ' . $tableRows->count() . ' rows in the first table');
                            
                            // Extract headers
                            $headers = [];
                            $headerRow = $tableRows->first();
                            $headerRow->filter('th')->each(function (Crawler $th) use (&$headers) {
                                $headers[] = trim($th->text());
                            });
                            
                            Log::info('Import form - Table headers: ' . json_encode($headers));
                            
                            // Process data rows
                            $tableRows->slice(1)->each(function (Crawler $row, $i) use (&$products, $headers) {
                                try {
                                    $cells = $row->filter('td');
                                    if ($cells->count() == 0) {
                                        return; // Skip if no cells (might be a header or empty row)
                                    }
                                    
                                    $productData = [
                                        'name' => 'Dell Laptop ' . ($i + 1),
                                        'specs' => [],
                                        'quantity' => 1,
                                        'price' => '0.00'
                                    ];
                                    
                                    // Extract data from cells using headers as keys
                                    for ($j = 0; $j < min($cells->count(), count($headers)); $j++) {
                                        $key = $headers[$j];
                                        $value = trim($cells->eq($j)->text());
                                        
                                        $productData['specs'][$key] = $value;
                                        
                                        // Map common fields to standardized properties
                                        if (stripos($key, 'model') !== false) {
                                            $productData['model'] = $value;
                                            $productData['name'] = $value;
                                        } elseif (stripos($key, 'type') !== false) {
                                            $productData['type'] = $value;
                                        } elseif (stripos($key, 'brand') !== false || stripos($key, 'producer') !== false) {
                                            $productData['producer'] = $value;
                                        } elseif (stripos($key, 'cpu') !== false || stripos($key, 'processor') !== false) {
                                            $productData['cpu'] = $value;
                                        } elseif (stripos($key, 'ram') !== false || stripos($key, 'memory') !== false) {
                                            $productData['ram'] = $value;
                                        } elseif (stripos($key, 'hdd') !== false || stripos($key, 'ssd') !== false || stripos($key, 'drive') !== false || stripos($key, 'storage') !== false) {
                                            $productData['drive'] = $value;
                                        } elseif (stripos($key, 'os') !== false || stripos($key, 'operating') !== false) {
                                            $productData['operating_system'] = $value;
                                        } elseif (stripos($key, 'price') !== false) {
                                            $productData['price'] = preg_replace('/[^0-9,.]/', '', $value);
                                            $productData['price'] = str_replace(',', '.', $productData['price']);
                                            $productData['price'] = (float)$productData['price'];
                                        } elseif (stripos($key, 'screen') !== false || stripos($key, 'display') !== false) {
                                            $productData['screen_size'] = $value;
                                        } elseif (stripos($key, 'grade') !== false && stripos($key, 'visual') !== false) {
                                            $productData['visual_grade'] = $value;
                                        } elseif (stripos($key, 'grade') !== false && stripos($key, 'tech') !== false) {
                                            $productData['tech_grade'] = $value;
                                        } elseif (stripos($key, 'battery') !== false) {
                                            $productData['battery'] = $value;
                                        } elseif (stripos($key, 'quantity') !== false) {
                                            $productData['quantity'] = (int)preg_replace('/[^0-9]/', '', $value);
                                        }
                                    }
                                    
                                    $products[] = $productData;
                                } catch (\Exception $e) {
                                    Log::error('Error extracting table row data: ' . $e->getMessage());
                                }
                            });
                        }
                    }
                }
            }
            
            // Collect products from standard layout
            $productRows->each(function (Crawler $row, $i) use (&$products) {
                try {
                    // Modello/Nome prodotto
                    $nameNode = $row->filter('.product-title');
                    $name = $nameNode->count() > 0 ? trim($nameNode->text()) : 'Unknown Product ' . ($i + 1);
                    
                    // Dettagli prodotto (specifiche)
                    $specs = [];
                    $specNodes = $row->filter('.product-property');
                    $specNodes->each(function (Crawler $specNode) use (&$specs) {
                        $label = $specNode->filter('.property-name');
                        $value = $specNode->filter('.property-value');
                        
                        if ($label->count() > 0 && $value->count() > 0) {
                            $labelText = trim($label->text());
                            $valueText = trim($value->text());
                            
                            // Rimuovi i due punti dal label se presenti
                            $labelText = rtrim($labelText, ':');
                            
                            $specs[$labelText] = $valueText;
                        }
                    });
                    
                    // Estrai prezzo unitario
                    $priceNode = $row->filter('.price');
                    $price = '';
                    if ($priceNode->count() > 0) {
                        $price = trim($priceNode->text());
                        // Estrai solo i numeri dal prezzo
                        $price = preg_replace('/[^0-9,.]/', '', $price);
                        // Converti virgole in punti
                        $price = str_replace(',', '.', $price);
                        // Converti esplicitamente in float
                        $price = (float)$price;
                    }
                    
                    // Estrai quantità
                    $quantity = 1; // Default
                    if (isset($specs['Quantity'])) {
                        $quantity = (int)preg_replace('/[^0-9]/', '', $specs['Quantity']);
                    }
                    
                    // Mappa i valori delle specifiche alle proprietà del prodotto
                    $productData = [
                        'name' => $name,
                        'type' => isset($specs['Type']) ? $specs['Type'] : null,
                        'model' => isset($specs['Model']) ? $specs['Model'] : $name,
                        'producer' => isset($specs['Brand']) ? $specs['Brand'] : (isset($specs['Producer']) ? $specs['Producer'] : null),
                        'cpu' => isset($specs['CPU']) ? $specs['CPU'] : (isset($specs['Processor']) ? $specs['Processor'] : null),
                        'ram' => isset($specs['RAM']) ? $specs['RAM'] : (isset($specs['Memory']) ? $specs['Memory'] : null),
                        'drive' => isset($specs['HDD']) ? $specs['HDD'] : (isset($specs['SSD']) ? $specs['SSD'] : (isset($specs['Storage']) ? $specs['Storage'] : null)),
                        'operating_system' => isset($specs['OS']) ? $specs['OS'] : (isset($specs['Operating System']) ? $specs['Operating System'] : null),
                        'gpu' => isset($specs['GPU']) ? $specs['GPU'] : (isset($specs['Graphics']) ? $specs['Graphics'] : null),
                        'color' => isset($specs['Color']) ? $specs['Color'] : null,
                        'screen_size' => isset($specs['Screen Size']) ? $specs['Screen Size'] : (isset($specs['Display']) ? $specs['Display'] : null),
                        'visual_grade' => isset($specs['Visual Grade']) ? $specs['Visual Grade'] : (isset($specs['Cosmetic']) ? $specs['Cosmetic'] : null),
                        'tech_grade' => isset($specs['Tech Grade']) ? $specs['Tech Grade'] : (isset($specs['Technical']) ? $specs['Technical'] : null),
                        'battery' => isset($specs['Battery']) ? $specs['Battery'] : null,
                        'price' => $price,
                        'quantity' => $quantity,
                        'specs' => $specs, // Manteniamo tutte le specifiche originali
                    ];
                    
                    $products[] = $productData;
                } catch (\Exception $e) {
                    Log::error('Error extracting product data for import form: ' . $e->getMessage());
                }
            });
            
            // Se non abbiamo trovato prodotti, ritorniamo un errore
            if (empty($products)) {
                return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                    ->with('error', 'No products found in the list');
            }
            
            // Ottieni l'elenco delle categorie per il dropdown
            $categories = \App\Models\Category::all();
            
            // Ottieni i parametri predefiniti per ogni categoria
            $categoryParameters = [];
            foreach ($categories as $category) {
                $categoryParameters[$category->id] = $category->attributes ?? [];
            }

            // Estraiamo tutti i possibili campi dai prodotti per il mapping
            $allFields = [];
            $sampleValues = [];
            
            // Raccogli tutti i campi disponibili dai prodotti
            foreach ($products as $product) {
                foreach ($product as $key => $value) {
                    if ($key !== 'specs' && !in_array($key, $allFields)) {
                        $allFields[] = $key;
                        $sampleValues[$key] = $value;
                    }
                }
                
                // Raccogli anche i campi nelle specifiche
                if (isset($product['specs']) && is_array($product['specs'])) {
                    foreach ($product['specs'] as $key => $value) {
                        $specKey = 'spec_' . $key;
                        if (!in_array($specKey, $allFields)) {
                            $allFields[] = $specKey;
                            $sampleValues[$specKey] = $value;
                        }
                    }
                }
            }
            
            // Ordina i campi alfabeticamente
            sort($allFields);
            
            // Suggerimenti di mapping predefiniti
            $defaultMappings = [
                'name' => 'name',
                'model' => 'model',
                'producer' => 'manufacturer',
                'visual_grade' => 'visual_grade',
                'tech_grade' => 'tech_grade',
                'price' => 'price',
                'quantity' => 'quantity',
                'cpu' => 'cpu',
                'ram' => 'ram',
                'drive' => 'storage',
                'operating_system' => 'os',
                'gpu' => 'gpu',
                'screen_size' => 'screen_size',
                'battery' => 'battery',
                'color' => 'color'
            ];
            
            // Prendi il primo prodotto come esempio
            $sampleProduct = !empty($products) ? $products[0] : null;
            
            return view('admin.itsale.import-form', compact(
                'supplier', 
                'listSlug', 
                'listDetails', 
                'products', 
                'sampleProduct',
                'allFields', 
                'sampleValues',
                'defaultMappings',
                'categories',
                'categoryParameters'
            ));
            
        } catch (\Exception $e) {
            Log::error('Exception while preparing import form: ' . $e->getMessage());
            return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                ->with('error', 'An error occurred while preparing the import form: ' . $e->getMessage());
        }
    }
    
    /**
     * Import a list as a batch.
     */
    public function importAsBatch(Request $request, ThirdPartySupplier $supplier = null, $listSlug)
    {
        // Verifica se è la richiesta iniziale o il submit del form di mappatura
        if (!$request->has('confirm_import')) {
            // Se è la richiesta iniziale, mostra il form di mappatura
            return $this->showImportForm($request, $supplier, $listSlug);
        }
        
        // Validazione dei dati di input
        $validatedData = $request->validate([
            'batch_name' => 'required|string|max:255',
            'batch_reference' => 'required|string|max:255',
            'batch_description' => 'nullable|string',
            'batch_status' => 'required|string|in:active,pending,sold,reserved',
            'category_id' => 'required|exists:categories,id',
            'source_type' => 'required|string|in:internal,external',
            'supplier' => 'nullable|string',
            'external_reference' => 'nullable|string',
            'batch_cost' => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'spec_fields' => 'required|array',
            'spec_params' => 'required|array',
            'spec_custom_params' => 'nullable|array',
            'additional_param_names' => 'nullable|array',
            'additional_param_values' => 'nullable|array',
            'extracted_visual_grade' => 'nullable|string',
            'extracted_tech_grade' => 'nullable|string',
            'extracted_problems' => 'nullable|string',
            'manual_visual_grade' => 'nullable|string',
            'manual_tech_grade' => 'nullable|string',
            'manual_problems' => 'nullable|string',
        ]);
        
        // Log dei dati ricevuti per debug
        Log::info('Import data received:', [
            'batch_info' => [
                'name' => $request->batch_name,
                'reference' => $request->batch_reference,
                'status' => $request->batch_status,
                'category_id' => $request->category_id,
            ],
            'source_info' => [
                'type' => $request->source_type,
                'supplier' => $request->supplier,
                'reference' => $request->external_reference,
            ],
            'costs' => [
                'batch_cost' => $request->batch_cost,
                'shipping_cost' => $request->shipping_cost,
                'tax_amount' => $request->tax_amount,
                'total_cost' => $request->total_cost,
            ],
            'extracted_grade_info' => [
                'visual_grade' => $request->extracted_visual_grade,
                'tech_grade' => $request->extracted_tech_grade,
                'problems' => $request->extracted_problems,
            ],
            'manual_grade_info' => [
                'visual_grade' => $request->manual_visual_grade,
                'tech_grade' => $request->manual_tech_grade,
                'problems' => $request->manual_problems,
            ],
            'mapping_count' => [
                'spec_fields' => count($request->spec_fields),
                'spec_params' => count($request->spec_params),
            ],
            'additional_params_count' => $request->additional_param_names ? count($request->additional_param_names) : 0,
        ]);
        
        // Costruisci il mapping dei campi
        $fieldMapping = [];
        foreach ($request->spec_fields as $index => $field) {
            $param = $request->spec_params[$index] ?? null;
            
            // Se è un parametro personalizzato, usa il valore specificato
            if ($param === 'custom' && isset($request->spec_custom_params[$index])) {
                $customParamName = $request->spec_custom_params[$index];
                if (!empty($customParamName)) {
                    $fieldMapping[$field] = $customParamName;
                }
            } 
            // Se non è vuoto e non è il parametro speciale per il grading, aggiungi al mapping
            elseif (!empty($param) && $param !== '_grade_special') {
                $fieldMapping[$field] = $param;
            }
        }
        
        // Raccogli parametri aggiuntivi
        $additionalParams = [];
        if ($request->additional_param_names && $request->additional_param_values) {
            foreach ($request->additional_param_names as $index => $name) {
                if (!empty($name) && isset($request->additional_param_values[$index])) {
                    $additionalParams[$name] = $request->additional_param_values[$index];
                }
            }
        }
        
        // Verifica se il parametro quantity è presente
        $hasQuantity = false;
        foreach ($fieldMapping as $field => $param) {
            if ($param === 'quantity') {
                $hasQuantity = true;
                break;
            }
        }
        
        // Se quantity non è presente nel mapping, aggiungi come parametro aggiuntivo
        if (!$hasQuantity && !isset($additionalParams['quantity'])) {
            $additionalParams['quantity'] = '1';
        }
        
        // Determina i valori finali di grading, dando priorità ai valori manuali
        $finalGradeInfo = [
            'visual_grade' => !empty($request->manual_visual_grade) ? $request->manual_visual_grade : $request->extracted_visual_grade,
            'tech_grade' => !empty($request->manual_tech_grade) ? $request->manual_tech_grade : $request->extracted_tech_grade,
            'problems' => !empty($request->manual_problems) ? $request->manual_problems : $request->extracted_problems,
        ];
        
        // Aggiungi parametri di grading ai parametri aggiuntivi se disponibili
        if (!empty($finalGradeInfo['visual_grade'])) {
            $additionalParams['visual_grade'] = $finalGradeInfo['visual_grade'];
        }
        
        if (!empty($finalGradeInfo['tech_grade'])) {
            $additionalParams['tech_grade'] = $finalGradeInfo['tech_grade'];
        }
        
        if (!empty($finalGradeInfo['problems'])) {
            $additionalParams['problems'] = $finalGradeInfo['problems'];
        }
        
        // Assicurati che ci sia almeno un valore di default per visual_grade e tech_grade se non specificati
        if (empty($additionalParams['visual_grade'])) {
            $additionalParams['visual_grade'] = 'B'; // Valore predefinito comune
        }
        
        if (empty($additionalParams['tech_grade'])) {
            $additionalParams['tech_grade'] = 'Working'; // Valore predefinito comune
        }
        
        // Costruisci la risposta con un riepilogo delle impostazioni di importazione
        $importSummary = [
            'batch_info' => [
                'name' => $request->batch_name,
                'reference' => $request->batch_reference,
                'description' => $request->batch_description,
                'status' => $request->batch_status,
                'category_id' => $request->category_id,
            ],
            'source_info' => [
                'type' => $request->source_type,
                'supplier' => $request->source_type === 'external' ? $request->supplier : null,
                'external_reference' => $request->external_reference,
            ],
            'costs' => [
                'batch_cost' => (float)$request->batch_cost,
                'shipping_cost' => (float)$request->shipping_cost,
                'tax_amount' => (float)$request->tax_amount,
                'total_cost' => (float)$request->total_cost,
            ],
            'field_mapping' => $fieldMapping,
            'additional_params' => $additionalParams,
            'grading_info' => $finalGradeInfo,
        ];
        
        // Ora implementiamo la creazione effettiva del batch con i prodotti
        try {
            // Ottieni i prodotti dalla lista ITSale
            $productsFromITSale = $this->getProductsFromITSaleList($listSlug);
            
            if (empty($productsFromITSale)) {
                return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                    ->with('error', 'Non sono stati trovati prodotti nella lista da importare.');
            }
            
            // Crea un nuovo batch
            $batch = new \App\Models\Batch();
            $batch->name = $request->batch_name;
            $batch->slug = \Illuminate\Support\Str::slug($request->batch_name);
            $batch->reference_code = $request->batch_reference;
            $batch->description = $request->batch_description;
            $batch->status = $request->batch_status;
            $batch->category_id = $request->category_id;
            $batch->source_type = $request->source_type;
            $batch->supplier = $request->source_type === 'external' ? $request->supplier : null;
            $batch->external_reference = $request->external_reference;
            $batch->batch_cost = (float)$request->batch_cost;
            $batch->shipping_cost = (float)$request->shipping_cost;
            $batch->tax_amount = (float)$request->tax_amount;
            $batch->total_cost = (float)$request->total_cost;
            
            // Ottieni la categoria selezionata
            $category = \App\Models\Category::find($request->category_id);
            
            // Determina il tipo di prodotto in base alla categoria
            $batch->product_type = $category->name ?? 'laptop';
            $batch->product_manufacturer = 'Dell'; // Default per questo batch specifico
            $batch->product_model = 'Laptop 8th Gen'; // Default per questo batch specifico
            
            // Calcola unità totali e prezzo unitario medio
            $totalUnits = 0;
            foreach ($productsFromITSale as $product) {
                $quantity = 1; // Default quantity
                
                // Controlla se c'è un parametro di quantità mappato
                foreach ($fieldMapping as $field => $param) {
                    if ($param === 'quantity' && isset($product['specs'][$field])) {
                        $quantity = (int)preg_replace('/[^0-9]/', '', $product['specs'][$field]);
                        if ($quantity < 1) $quantity = 1;
                        break;
                    }
                }
                
                // Aggiunge la quantità dal parametro aggiuntivo se presente
                if (isset($additionalParams['quantity']) && !$hasQuantity) {
                    $quantity = (int)$additionalParams['quantity'];
                    if ($quantity < 1) $quantity = 1;
                }
                
                $totalUnits += $quantity;
            }
            
            $batch->total_units = $totalUnits;
            $batch->unit_quantity = $totalUnits;
            $batch->unit_price = $totalUnits > 0 ? $batch->total_cost / $totalUnits : 0;
            $batch->total_price = (float)$request->total_cost;
            
            // Prepara l'array di prodotti per salvare nel batch
            $batchProducts = [];
            
            foreach ($productsFromITSale as $index => $product) {
                $productData = [];
                
                // Mappatura campi dalle specifiche ITSale ai campi del prodotto
                foreach ($fieldMapping as $field => $param) {
                    if (isset($product['specs'][$field])) {
                        $productData[$param] = $product['specs'][$field];
                    }
                }
                
                // Aggiungi parametri aggiuntivi
                foreach ($additionalParams as $paramName => $paramValue) {
                    $productData[$paramName] = $paramValue;
                }
                
                // Assicurati che ci siano i campi obbligatori
                if (!isset($productData['name']) && isset($product['model'])) {
                    $productData['name'] = $product['model'];
                } elseif (!isset($productData['name']) && isset($product['name'])) {
                    $productData['name'] = $product['name'];
                } elseif (!isset($productData['name'])) {
                    // Crea un nome di default
                    $productData['name'] = $category->name . ' - Prodotto ' . ($index + 1);
                }
                
                // Genera lo slug dal nome
                $productData['slug'] = \Illuminate\Support\Str::slug($productData['name']);
                
                // Determina la quantità
                $quantity = 1; // Default
                if (isset($productData['quantity'])) {
                    $quantity = (int)preg_replace('/[^0-9]/', '', $productData['quantity']);
                    if ($quantity < 1) $quantity = 1;
                }
                
                $productData['quantity'] = $quantity;
                $productData['unit_price'] = $batch->unit_price;
                
                // Assicurati che il prezzo totale sia calcolato correttamente
                $productData['price'] = $quantity * $batch->unit_price;
                
                // Aggiungi il prodotto all'array dei prodotti del batch
                $batchProducts[] = $productData;
            }
            
            // Salva l'array dei prodotti nel batch
            $batch->products = $batchProducts;
            
            // Salva il batch
            $batch->save();
            
            Log::info('Batch creato con successo:', [
                'batch_id' => $batch->id, 
                'name' => $batch->name, 
                'total_units' => $batch->total_units,
                'products_count' => count($batchProducts)
            ]);
            
            return redirect()->route('admin.batches.show', $batch->id)
                ->with('success', 'Batch importato con successo! Sono stati importati ' . count($batchProducts) . ' prodotti.');
                
        } catch (\Exception $e) {
            Log::error('Errore durante l\'importazione del batch:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug])
                ->with('error', 'Si è verificato un errore durante l\'importazione: ' . $e->getMessage())
                ->with('import_summary', $importSummary);
        }
    }
    
    /**
     * Ottiene i prodotti da una lista ITSale
     */
    private function getProductsFromITSaleList($listSlug)
    {
        // Recupera i prodotti dalla lista ITSale
        $productsUrl = "https://itsale.pl/list/{$listSlug}";
        $productsResponse = Http::timeout(60)->get($productsUrl);
        
        if (!$productsResponse->successful()) {
            Log::error('Errore durante il recupero dei prodotti da ITSale:', [
                'status' => $productsResponse->status(),
                'url' => $productsUrl
            ]);
            return [];
        }
        
        $productsHtml = $productsResponse->body();
        $productsCrawler = new Crawler($productsHtml);
        
        // Estrai i prodotti dalla pagina
        $products = [];
        $productRows = $productsCrawler->filter('.product-list-item');
        
        // Debug info
        Log::info('Trovati ' . $productRows->count() . ' prodotti usando il selettore .product-list-item');
        
        // Try alternative selectors if no products found
        if ($productRows->count() == 0) {
            Log::info('Provo selettore alternativo: tr.product-row');
            $productRows = $productsCrawler->filter('tr.product-row');
            Log::info('Trovati ' . $productRows->count() . ' prodotti usando il selettore tr.product-row');
            
            if ($productRows->count() == 0) {
                Log::info('Provo un altro selettore: .product');
                $productRows = $productsCrawler->filter('.product');
                Log::info('Trovati ' . $productRows->count() . ' prodotti usando il selettore .product');
                
                // If still no products, try processing tables directly
                if ($productRows->count() == 0) {
                    Log::info('Provo a processare le tabelle direttamente');
                    $tables = $productsCrawler->filter('table');
                    Log::info('Trovate ' . $tables->count() . ' tabelle nella pagina');
                    
                    if ($tables->count() > 0) {
                        // Process the first table with data
                        $tableRows = $tables->first()->filter('tr');
                        Log::info('Trovate ' . $tableRows->count() . ' righe nella prima tabella');
                        
                        // Extract headers
                        $headers = [];
                        $headerRow = $tableRows->first();
                        $headerRow->filter('th')->each(function (Crawler $th) use (&$headers) {
                            $headers[] = trim($th->text());
                        });
                        
                        Log::info('Headers della tabella: ' . json_encode($headers));
                        
                        // Process data rows
                        $tableRows->slice(1)->each(function (Crawler $row, $i) use (&$products, $headers) {
                            try {
                                $cells = $row->filter('td');
                                if ($cells->count() == 0) {
                                    return; // Skip if no cells (might be a header or empty row)
                                }
                                
                                $productData = [
                                    'name' => 'Dell Laptop ' . ($i + 1),
                                    'specs' => [],
                                    'quantity' => 1,
                                    'price' => '0.00'
                                ];
                                
                                // Extract data from cells using headers as keys
                                for ($j = 0; $j < min($cells->count(), count($headers)); $j++) {
                                    $key = $headers[$j];
                                    $value = trim($cells->eq($j)->text());
                                    
                                    $productData['specs'][$key] = $value;
                                    
                                    // Map common fields to standardized properties
                                    if (stripos($key, 'model') !== false) {
                                        $productData['model'] = $value;
                                        $productData['name'] = $value;
                                    } elseif (stripos($key, 'type') !== false) {
                                        $productData['type'] = $value;
                                    } elseif (stripos($key, 'brand') !== false || stripos($key, 'producer') !== false) {
                                        $productData['producer'] = $value;
                                    } elseif (stripos($key, 'cpu') !== false || stripos($key, 'processor') !== false) {
                                        $productData['cpu'] = $value;
                                    } elseif (stripos($key, 'ram') !== false || stripos($key, 'memory') !== false) {
                                        $productData['ram'] = $value;
                                    } elseif (stripos($key, 'hdd') !== false || stripos($key, 'ssd') !== false || stripos($key, 'drive') !== false || stripos($key, 'storage') !== false) {
                                        $productData['drive'] = $value;
                                    } elseif (stripos($key, 'os') !== false || stripos($key, 'operating') !== false) {
                                        $productData['operating_system'] = $value;
                                    } elseif (stripos($key, 'price') !== false) {
                                        $productData['price'] = preg_replace('/[^0-9,.]/', '', $value);
                                        $productData['price'] = str_replace(',', '.', $productData['price']);
                                        $productData['price'] = (float)$productData['price'];
                                    } elseif (stripos($key, 'screen') !== false || stripos($key, 'display') !== false) {
                                        $productData['screen_size'] = $value;
                                    } elseif (stripos($key, 'grade') !== false && stripos($key, 'visual') !== false) {
                                        $productData['visual_grade'] = $value;
                                    } elseif (stripos($key, 'grade') !== false && stripos($key, 'tech') !== false) {
                                        $productData['tech_grade'] = $value;
                                    } elseif (stripos($key, 'battery') !== false) {
                                        $productData['battery'] = $value;
                                    } elseif (stripos($key, 'quantity') !== false) {
                                        $productData['quantity'] = (int)preg_replace('/[^0-9]/', '', $value);
                                    }
                                }
                                
                                $products[] = $productData;
        } catch (\Exception $e) {
                                Log::error('Errore durante l\'estrazione dei dati della riga della tabella: ' . $e->getMessage());
                            }
                        });
                    }
                }
            }
        }
        
        // Collect products from standard layout
        $productRows->each(function (Crawler $row, $i) use (&$products) {
            try {
                // Modello/Nome prodotto
                $nameNode = $row->filter('.product-title');
                $name = $nameNode->count() > 0 ? trim($nameNode->text()) : 'Unknown Product ' . ($i + 1);
                
                // Dettagli prodotto (specifiche)
                $specs = [];
                $specNodes = $row->filter('.product-property');
                $specNodes->each(function (Crawler $specNode) use (&$specs) {
                    $label = $specNode->filter('.property-name');
                    $value = $specNode->filter('.property-value');
                    
                    if ($label->count() > 0 && $value->count() > 0) {
                        $labelText = trim($label->text());
                        $valueText = trim($value->text());
                        
                        // Rimuovi i due punti dal label se presenti
                        $labelText = rtrim($labelText, ':');
                        
                        $specs[$labelText] = $valueText;
                    }
                });
                
                // Estrai prezzo unitario
                $priceNode = $row->filter('.price');
                $price = '';
                if ($priceNode->count() > 0) {
                    $price = trim($priceNode->text());
                    // Estrai solo i numeri dal prezzo
                    $price = preg_replace('/[^0-9,.]/', '', $price);
                    // Converti virgole in punti
                    $price = str_replace(',', '.', $price);
                    // Converti esplicitamente in float
                    $price = (float)$price;
                }
                
                // Estrai quantità
                $quantity = 1; // Default
                if (isset($specs['Quantity'])) {
                    $quantity = (int)preg_replace('/[^0-9]/', '', $specs['Quantity']);
                }
                
                // Mappa i valori delle specifiche alle proprietà del prodotto
                $productData = [
                    'name' => $name,
                    'type' => isset($specs['Type']) ? $specs['Type'] : null,
                    'model' => isset($specs['Model']) ? $specs['Model'] : $name,
                    'producer' => isset($specs['Brand']) ? $specs['Brand'] : (isset($specs['Producer']) ? $specs['Producer'] : null),
                    'cpu' => isset($specs['CPU']) ? $specs['CPU'] : (isset($specs['Processor']) ? $specs['Processor'] : null),
                    'ram' => isset($specs['RAM']) ? $specs['RAM'] : (isset($specs['Memory']) ? $specs['Memory'] : null),
                    'drive' => isset($specs['HDD']) ? $specs['HDD'] : (isset($specs['SSD']) ? $specs['SSD'] : (isset($specs['Storage']) ? $specs['Storage'] : null)),
                    'operating_system' => isset($specs['OS']) ? $specs['OS'] : (isset($specs['Operating System']) ? $specs['Operating System'] : null),
                    'gpu' => isset($specs['GPU']) ? $specs['GPU'] : (isset($specs['Graphics']) ? $specs['Graphics'] : null),
                    'color' => isset($specs['Color']) ? $specs['Color'] : null,
                    'screen_size' => isset($specs['Screen Size']) ? $specs['Screen Size'] : (isset($specs['Display']) ? $specs['Display'] : null),
                    'visual_grade' => isset($specs['Visual Grade']) ? $specs['Visual Grade'] : (isset($specs['Cosmetic']) ? $specs['Cosmetic'] : null),
                    'tech_grade' => isset($specs['Tech Grade']) ? $specs['Tech Grade'] : (isset($specs['Technical']) ? $specs['Technical'] : null),
                    'battery' => isset($specs['Battery']) ? $specs['Battery'] : null,
                    'price' => $price,
                    'quantity' => $quantity,
                    'specs' => $specs, // Manteniamo tutte le specifiche originali
                ];
                
                $products[] = $productData;
            } catch (\Exception $e) {
                Log::error('Errore durante l\'estrazione dei dati del prodotto: ' . $e->getMessage());
            }
        });
        
        return $products;
    }

    /**
     * Process raw item data to extract standardized fields.
     */
    private function processItemData($item, $headers = [])
    {
        $processedItem = [];
        
        // Copy all original data
        foreach ($item as $key => $value) {
            $processedItem[$key] = $value;
        }
        
        // Extract common fields using pattern matching
        foreach ($item as $key => $value) {
            // Model/Name
            if (stripos($key, 'model') !== false) {
                $processedItem['model'] = $value;
                $processedItem['name'] = $value;
            } 
            // Type
            elseif (stripos($key, 'type') !== false) {
                $processedItem['type'] = $value;
            }
            // Producer/Brand
            elseif (stripos($key, 'brand') !== false || stripos($key, 'producer') !== false || stripos($key, 'manufacturer') !== false) {
                $processedItem['producer'] = $value;
            }
            // CPU/Processor
            elseif (stripos($key, 'cpu') !== false || stripos($key, 'processor') !== false) {
                $processedItem['cpu'] = $value;
            }
            // RAM/Memory
            elseif (stripos($key, 'ram') !== false || stripos($key, 'memory') !== false) {
                $processedItem['ram'] = $value;
            }
            // Storage
            elseif (stripos($key, 'hdd') !== false || stripos($key, 'ssd') !== false || 
                    stripos($key, 'drive') !== false || stripos($key, 'storage') !== false) {
                $processedItem['drive'] = $value;
            }
            // OS
            elseif (stripos($key, 'os') !== false || stripos($key, 'operating') !== false) {
                $processedItem['operating_system'] = $value;
            }
            // Price
            elseif (stripos($key, 'price') !== false) {
                $price = preg_replace('/[^0-9,.]/', '', $value);
                $price = str_replace(',', '.', $price);
                $processedItem['price'] = (float)$price;
            }
            // Screen
            elseif (stripos($key, 'screen') !== false || stripos($key, 'display') !== false) {
                $processedItem['screen_size'] = $value;
            }
            // Grades
            elseif (stripos($key, 'grade') !== false && stripos($key, 'visual') !== false) {
                $processedItem['visual_grade'] = $value;
            }
            elseif (stripos($key, 'grade') !== false && stripos($key, 'tech') !== false) {
                $processedItem['tech_grade'] = $value;
            }
            // Battery
            elseif (stripos($key, 'battery') !== false) {
                $processedItem['battery'] = $value;
            }
            // Quantity
            elseif (stripos($key, 'quantity') !== false) {
                $processedItem['quantity'] = (int)preg_replace('/[^0-9]/', '', $value);
            }
        }
        
        // Ensure we have a name
        if (!isset($processedItem['name']) && isset($processedItem['model'])) {
            $processedItem['name'] = $processedItem['model'];
        } elseif (!isset($processedItem['name']) && isset($processedItem['producer'])) {
            $processedItem['name'] = $processedItem['producer'] . ' Product';
        } elseif (!isset($processedItem['name'])) {
            // Default fallback
            $processedItem['name'] = 'HP Product';
        }
        
        return $processedItem;
    }
} 