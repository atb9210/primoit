<?php

namespace App\Http\Controllers;

use App\Models\ThirdPartySupplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ITSaleScraperController;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class CatalogController extends Controller
{
    /**
     * Display the public catalog for a supplier.
     *
     * @param  \App\Models\ThirdPartySupplier  $supplier
     * @param  string  $listSlug
     * @return \Illuminate\Http\Response
     */
    public function show(ThirdPartySupplier $supplier, $listSlug = null)
    {
        // Get supplier margin from credentials
        $margin = $supplier->credentials['margin'] ?? 20;
        $whatsapp = $supplier->credentials['whatsapp'] ?? '';
        
        // Normalize WhatsApp number (remove spaces and ensure it starts with +)
        $whatsapp = preg_replace('/\s+/', '', $whatsapp);
        if ($whatsapp && substr($whatsapp, 0, 1) !== '+') {
            $whatsapp = '+' . $whatsapp;
        }

        // Debug info
        Log::info('CatalogController::show', [
            'supplier_id' => $supplier->id,
            'supplier_name' => $supplier->name,
            'listSlug' => $listSlug
        ]);

        // Usa i dati in modo diretto invece di chiamare metodi che non esistono
        $lists = [];
        $list = null;
        $products = [];
        
        try {
            if ($listSlug) {
                // Se è richiesta una lista specifica, otteniamo i suoi prodotti
                Log::info('Fetching products for list: ' . $listSlug);
                
                // Ottieni i prodotti direttamente
                $products = $this->getProductsFromITSaleList($listSlug);
                
                Log::info('Products fetched: ' . count($products));
                
                // Otteniamo anche le informazioni sulla lista
                $list = ['name' => ucwords(str_replace('-', ' ', $listSlug)), 'slug' => $listSlug];
            } else {
                // Altrimenti ottieni tutte le liste disponibili
                $lists = $this->getAvailableLists($supplier);
                Log::info('Lists fetched: ' . count($lists));
            }
            
            // Applica il margine ai prezzi dei prodotti
            if (!empty($products)) {
                foreach ($products as &$product) {
                    if (isset($product['price'])) {
                        // Calcola il prezzo con il margine
                        $originalPrice = floatval(str_replace(['€', ','], ['', '.'], $product['price']));
                        $priceWithMargin = $originalPrice * (1 + ($margin / 100));
                        $product['original_price'] = $product['price'];
                        $product['price'] = '€' . number_format($priceWithMargin, 2, ',', '.');
                    }
                }
            }
            
            // Return the catalog view
            return view('catalog.show', [
                'supplier' => $supplier,
                'lists' => $lists,
                'list' => $list,
                'products' => $products,
                'margin' => $margin,
                'whatsapp' => $whatsapp,
                'listSlug' => $listSlug
            ]);
        } catch (\Exception $e) {
            Log::error('Error in catalog display: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return view('catalog.show', [
                'supplier' => $supplier,
                'lists' => [],
                'list' => null,
                'products' => [],
                'margin' => $margin,
                'whatsapp' => $whatsapp,
                'error' => 'Unable to fetch catalog data: ' . $e->getMessage(),
                'listSlug' => $listSlug
            ]);
        }
    }

    /**
     * Get available lists from supplier
     * 
     * @param ThirdPartySupplier $supplier
     * @return array
     */
    private function getAvailableLists(ThirdPartySupplier $supplier)
    {
        // Fetch data directly using HTTP
        $response = Http::timeout(60)->get('https://itsale.pl/list');
        
        if (!$response->successful()) {
            return [];
        }
        
        $html = $response->body();
        $lists = [];
        
        try {
            // Parse with crawler
            $crawler = new Crawler($html);
            $listRows = $crawler->filter('.row');
            
            $listRows->each(function (Crawler $row) use (&$lists) {
                try {
                    // Extract units
                    $unitsNode = $row->filter('.units-average b')->first();
                    $units = $unitsNode->count() > 0 ? trim($unitsNode->text()) : '0';
                    
                    // Extract average price
                    $avgPriceNode = $row->filter('.units-average b')->eq(1);
                    $avgPrice = $avgPriceNode->count() > 0 ? trim($avgPriceNode->text()) : '';
                    
                    // Extract name
                    $nameNode = $row->filter('.list-card-wrapper-link');
                    $name = $nameNode->count() > 0 ? trim($nameNode->text()) : '';
                    
                    // Extract description
                    $descNode = $row->filter('.list-description');
                    $description = $descNode->count() > 0 ? trim($descNode->text()) : '';
                    
                    // Extract price
                    $finalPriceNode = $row->filter('.list-price');
                    $finalPrice = '';
                    if ($finalPriceNode->count() > 0) {
                        $finalPrice = $finalPriceNode->text();
                        $finalPrice = preg_replace('/\s+/', '', $finalPrice);
                    }
                    
                    if (!empty($name)) {
                        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
                        
                        $lists[] = [
                            'name' => $name,
                            'description' => $description,
                            'products_count' => (int)$units,
                            'avg_price' => $avgPrice,
                            'total_price' => $finalPrice,
                            'slug' => $slug
                        ];
                    }
                } catch (\Exception $e) {
                    Log::error('Error extracting list data: ' . $e->getMessage());
                }
            });
        } catch (\Exception $e) {
            Log::error('Error getting available lists: ' . $e->getMessage());
        }
        
        return $lists;
    }

    /**
     * Generate a catalog for a specific supplier.
     *
     * @param  \App\Models\ThirdPartySupplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function generate(ThirdPartySupplier $supplier)
    {
        // Redirect to the catalog view
        return redirect()->route('catalog.show', ['supplier' => $supplier->id]);
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
        
        // Salva l'HTML per debug
        file_put_contents(storage_path('logs/catalog_products_' . $listSlug . '.html'), $productsHtml);
        
        $productsCrawler = new Crawler($productsHtml);
        
        // Estrai i prodotti dalla pagina - cerca tabelle con dati
        $products = [];
        
        // Trova tutte le tabelle nella pagina
        $tables = $productsCrawler->filter('table');
        Log::info('Trovate ' . $tables->count() . ' tabelle nella pagina');
        
        if ($tables->count() > 0) {
            // Trova la tabella principale dei prodotti (solitamente la prima o seconda tabella)
            $mainTable = null;
            
            // Cerca la tabella che contiene header come "Model", "Brand", ecc.
            $tables->each(function (Crawler $table, $tableIndex) use (&$mainTable) {
                if ($mainTable !== null) return;
                
                $headers = [];
                $headerRow = $table->filter('tr')->first();
                
                // Controlla se ci sono header che sembrano essere per una tabella di prodotti
                $headerRow->filter('th')->each(function (Crawler $th) use (&$headers) {
                    $headerText = trim($th->text());
                    $headers[] = $headerText;
                });
                
                Log::info('Tabella #' . $tableIndex . ' headers: ' . json_encode($headers));
                
                // Verifica se questa tabella ha intestazioni tipiche per prodotti
                $productHeaderKeywords = ['model', 'manufacturer', 'brand', 'cpu', 'ram', 'storage', 'grade'];
                $isProductTable = false;
                
                foreach ($headers as $header) {
                    foreach ($productHeaderKeywords as $keyword) {
                        if (stripos($header, $keyword) !== false) {
                            $isProductTable = true;
                            break 2;
                        }
                    }
                }
                
                if ($isProductTable) {
                    $mainTable = $table;
                    Log::info('Trovata tabella principale dei prodotti (#' . $tableIndex . ')');
                }
            });
            
            // Se non abbiamo trovato una tabella specifica, usa la prima tabella
            if ($mainTable === null && $tables->count() > 0) {
                $mainTable = $tables->first();
                Log::info('Usando la prima tabella come fallback');
            }
            
            // Elabora la tabella principale se l'abbiamo trovata
            if ($mainTable !== null) {
                $tableRows = $mainTable->filter('tr');
                Log::info('Trovate ' . $tableRows->count() . ' righe nella tabella principale');
                
                if ($tableRows->count() > 0) {
                    // Estrai le intestazioni (la prima riga)
                    $headers = [];
                    $tableRows->first()->filter('th')->each(function (Crawler $th) use (&$headers) {
                        $headers[] = trim($th->text());
                    });
                    
                    // Se non ci sono intestazioni th, prova a vedere se la prima riga contiene td con intestazioni
                    if (empty($headers)) {
                        $tableRows->first()->filter('td')->each(function (Crawler $td) use (&$headers) {
                            $headers[] = trim($td->text());
                        });
                        
                        // Se abbiamo trovato intestazioni nelle celle td, skippiamo la prima riga
                        $dataRows = $tableRows->slice(1);
                    } else {
                        // Altrimenti, usa tutte le righe tranne la prima (header)
                        $dataRows = $tableRows->slice(1);
                    }
                    
                    Log::info('Headers della tabella principale: ' . json_encode($headers));
                    
                    // Ora elabora ogni riga di dati
                    foreach ($dataRows as $rowIndex => $row) {
                        try {
                            // Converti $row in un oggetto Crawler per poter usare il metodo filter()
                            $rowCrawler = new Crawler($row);
                            $cells = $rowCrawler->filter('td');
                            
                            if ($cells->count() == 0) {
                                continue; // Salta righe senza celle
                            }
                            
                            // Crea un array di specifiche per ogni prodotto usando gli header
                            $productSpecs = [];
                            $standardFields = [];
                            
                            // Per ogni cella, mappa il valore all'header corrispondente
                            for ($i = 0; $i < min($cells->count(), count($headers)); $i++) {
                                $headerKey = $headers[$i];
                                $cellValue = trim($cells->eq($i)->text());
                                
                                // Salva tutte le specifiche con l'header esatto come chiave
                                $productSpecs[$headerKey] = $cellValue;
                                
                                // Estrai anche informazioni standard in base al contenuto dell'header
                                $this->extractStandardField($headerKey, $cellValue, $standardFields);
                                
                                // Cerca immagini nella cella
                                try {
                                    $imgNode = $cells->eq($i)->filter('img');
                                    if ($imgNode->count() > 0) {
                                        $standardFields['image'] = $imgNode->attr('src');
                                    }
                                } catch (\Exception $e) {
                                    // No image in this cell
                                }
                            }
                            
                            // Crea il prodotto
                            $product = [
                                'name' => $standardFields['name'] ?? ($standardFields['model'] ?? ('Product ' . ($rowIndex + 1))),
                                'model' => $standardFields['model'] ?? null,
                                'producer' => $standardFields['producer'] ?? null,
                                'visual_grade' => $standardFields['visual_grade'] ?? null,
                                'tech_grade' => $standardFields['tech_grade'] ?? null,
                                'price' => $standardFields['price'] ?? 0,
                                'quantity' => $standardFields['quantity'] ?? 1,
                                'image' => $standardFields['image'] ?? null,
                                
                                // Importante: salva tutte le specifiche originali con i nomi degli header originali
                                'specs' => $productSpecs
                            ];
                            
                            // Aggiungi altri campi standard che possono essere presenti
                            foreach ($standardFields as $key => $value) {
                                if (!isset($product[$key])) {
                                    $product[$key] = $value;
                                }
                            }
                            
                            $products[] = $product;
                        } catch (\Exception $e) {
                            Log::error('Errore durante l\'elaborazione della riga #' . $rowIndex . ': ' . $e->getMessage());
                        }
                    }
                }
            }
        }
        
        // Se non abbiamo trovato prodotti da tabelle, proviamo altri metodi di estrazione
        if (empty($products)) {
            Log::info('Nessun prodotto trovato nelle tabelle, provo altri metodi di estrazione');
            
            // Qui potremmo implementare altri metodi di estrazione se necessario
        }
        
        // Log dei dati estratti per debug
        if (count($products) > 0) {
            Log::info('Estratti ' . count($products) . ' prodotti dalla lista.');
            Log::info('Esempio primo prodotto:', [
                'specs' => isset($products[0]['specs']) ? json_encode($products[0]['specs']) : 'Nessuna specifica',
                'standard_fields' => json_encode(array_diff_key($products[0], ['specs' => true]))
            ]);
        } else {
            Log::warning('Nessun prodotto estratto dalla lista ' . $listSlug);
        }
        
        return $products;
    }
    
    /**
     * Estrae campi standard dalle intestazioni della tabella e dai valori delle celle
     */
    private function extractStandardField($headerKey, $cellValue, &$standardFields)
    {
        // Normalizza l'header per il confronto
        $normalizedHeader = strtolower(trim($headerKey));
        
        // Estrai dati in base al tipo di header
        if (stripos($normalizedHeader, 'model') !== false) {
            $standardFields['model'] = $cellValue;
            $standardFields['name'] = $cellValue; // Usa model come nome se non viene specificato altro
        }
        elseif (stripos($normalizedHeader, 'manufacturer') !== false || stripos($normalizedHeader, 'brand') !== false || stripos($normalizedHeader, 'producer') !== false) {
            $standardFields['producer'] = $cellValue;
            $standardFields['manufacturer'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'cpu') !== false || stripos($normalizedHeader, 'processor') !== false) {
            $standardFields['cpu'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'ram') !== false || stripos($normalizedHeader, 'memory') !== false) {
            $standardFields['ram'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'storage') !== false || stripos($normalizedHeader, 'hdd') !== false || stripos($normalizedHeader, 'ssd') !== false || stripos($normalizedHeader, 'drive') !== false) {
            $standardFields['storage'] = $cellValue;
            $standardFields['drive'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'visual') !== false && stripos($normalizedHeader, 'grade') !== false) {
            $standardFields['visual_grade'] = $cellValue;
            
            // Estrai anche tech_grade e problems se presenti nel campo visual_grade
            if (preg_match('/Functionality:\s+(Working\*?|Not\s+working)/i', $cellValue, $matches)) {
                $standardFields['functionality'] = $matches[1];
                $standardFields['tech_grade'] = $matches[1];
            }
            
            if (preg_match('/Problems:([^;]+)/i', $cellValue, $matches)) {
                $standardFields['problems'] = trim($matches[1]);
            }
        }
        elseif ((stripos($normalizedHeader, 'tech') !== false && stripos($normalizedHeader, 'grade') !== false) || 
                stripos($normalizedHeader, 'functionality') !== false) {
            $standardFields['tech_grade'] = $cellValue;
            $standardFields['functionality'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'problem') !== false) {
            $standardFields['problems'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'grade') !== false) {
            // General grade field
            $standardFields['grade'] = $cellValue;
            // Se non abbiamo un visual_grade specifico, usiamo questo
            if (!isset($standardFields['visual_grade'])) {
                $standardFields['visual_grade'] = $cellValue;
            }
        }
        elseif (stripos($normalizedHeader, 'screen') !== false && stripos($normalizedHeader, 'size') !== false) {
            $standardFields['screen_size'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'resolution') !== false) {
            $standardFields['resolution'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'price') !== false) {
            $standardFields['price'] = $cellValue;
        }
        elseif (stripos($normalizedHeader, 'quantity') !== false || stripos($normalizedHeader, 'qty') !== false) {
            $standardFields['quantity'] = $cellValue;
        }
    }
} 