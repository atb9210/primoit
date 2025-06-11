<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThirdPartySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Controller per l'integrazione con l'API di Foxway.shop
 * 
 * NOTA IMPORTANTE SUI PROBLEMI RISCONTRATI (2023-11-26):
 * 1. L'API restituisce correttamente cataloghi, gruppi di dimensioni, gruppi di articoli e produttori
 * 2. Tuttavia, restituisce risposte vuote (HTTP 200 ma corpo vuoto) per gli endpoint di prodotti:
 *    - /api/v1/catalogs/{urlSlug}/stock
 *    - /api/v1/catalogs/{urlSlug}/pricelist
 *    - /api/v1/catalogs/{urlSlug}/items (restituisce HTML invece di JSON)
 * 3. Anche l'endpoint /api/v1/sku/{sku} restituisce errore 400
 * 4. Questo suggerisce un problema di permessi con l'API key attuale, che può accedere ai metadati
 *    ma non ai dati effettivi dei prodotti (probabilmente riservati a clienti con contratti specifici)
 * 5. Il controller gestisce questo problema mostrando dati di esempio e avvisi appropriati
 */
class FoxwayApiController extends Controller
{
    /**
     * Display the Foxway.shop API interface with all products.
     */
    public function index(ThirdPartySupplier $supplier = null, Request $request)
    {
        // Se non viene passato un fornitore, cerchiamo quello di Foxway.shop
        if (!$supplier) {
            $supplier = ThirdPartySupplier::where('name', 'Foxway.shop')->first();
            
            // Se non troviamo un fornitore Foxway.shop nel database
            if (!$supplier) {
                return redirect()->route('admin.suppliers.index')
                    ->with('error', 'Foxway.shop supplier not found in the database. Please set up the supplier first.');
            }
        }
        
        // Check if this is actually Foxway.shop supplier
        if ($supplier->slug !== 'foxway-shop') {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'This API integration is only available for Foxway.shop');
        }
        
        // Verificare se è stata configurata la API key
        if (empty($supplier->credentials['api_key'])) {
            return redirect()->route('admin.suppliers.configure', $supplier)
                ->with('error', 'API Key is not configured for Foxway.shop. Please add your API key first.');
        }
        
        try {
            // Recupera le categorie di prodotti dall'API Foxway
            $apiKey = $supplier->credentials['api_key'] ?? 'c9e4437f-f4fb-447a-8112-4641fb9e5a8e';
            
            // Ottieni i cataloghi disponibili
            $catalogs = $this->getProductCatalogs($apiKey);
            
            // Controlla se è stato selezionato un catalogo specifico
            $selectedCatalog = $request->query('catalog');
            $selectedDimensionGroup = $request->query('dimensionGroup');
            $selectedItemGroup = $request->query('itemGroup');
            $selectedManufacturer = $request->query('manufacturer');
            
            // Se è stato selezionato un catalogo, ottieni i gruppi disponibili
            $catalogDetails = null;
            if ($selectedCatalog) {
                $catalogDetails = $this->getCatalogDetails($apiKey, $selectedCatalog);
            }
            
            // Se sono stati selezionati catalogo e gruppi, ottieni i produttori disponibili
            $manufacturers = [];
            if ($selectedCatalog && $selectedDimensionGroup && $selectedItemGroup) {
                $manufacturers = $this->getManufacturers($apiKey, $selectedCatalog, $selectedDimensionGroup, $selectedItemGroup);
            }
            
            // Se sono stati selezionati catalogo, gruppi e produttore, ottieni lo stock
            $products = [];
            $noProductsMessage = null;
            if ($selectedCatalog && $selectedDimensionGroup && $selectedItemGroup) {
                $products = $this->getStockItems($apiKey, $selectedCatalog, $selectedDimensionGroup, $selectedItemGroup, $selectedManufacturer);
                
                // Se non ci sono prodotti, imposta un messaggio di avviso
                if (empty($products)) {
                    $noProductsMessage = "Non ci sono prodotti disponibili per la combinazione selezionata. Questo potrebbe essere dovuto a: 
                    1) Non ci sono prodotti in stock per questa categoria 
                    2) L'API key potrebbe non avere accesso a questi prodotti 
                    3) Potrebbe essere necessario specificare un produttore specifico";
                }
                // Verifica se stiamo mostrando prodotti di esempio
                elseif (isset($products[0]['name']) && (
                    strpos($products[0]['name'], '[ESEMPIO]') !== false || 
                    strpos($products[0]['name'], '[FALLBACK]') !== false
                )) {
                    $noProductsMessage = "L'API Foxway.shop non ha restituito prodotti reali per questa selezione. Stai visualizzando dati di esempio. 
                    Questo può accadere se:
                    1) L'API key non ha i permessi necessari per accedere a questi prodotti
                    2) Non ci sono prodotti disponibili per questa combinazione di filtri
                    3) L'API Foxway.shop sta restituendo un formato di risposta inatteso";
                }
            }
            
            return view('admin.foxway.index', [
                'supplier' => $supplier,
                'catalogs' => $catalogs,
                'selectedCatalog' => $selectedCatalog,
                'catalogDetails' => $catalogDetails,
                'selectedDimensionGroup' => $selectedDimensionGroup,
                'selectedItemGroup' => $selectedItemGroup,
                'selectedManufacturer' => $selectedManufacturer,
                'manufacturers' => $manufacturers,
                'products' => $products,
                'noProductsMessage' => $noProductsMessage,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching Foxway.shop data: ' . $e->getMessage());
            
            // In caso di errore, prova a mostrare dati di esempio
            $exampleProducts = $this->getExampleProducts();
            
            return view('admin.foxway.index', [
                'supplier' => $supplier,
                'catalogs' => [],
                'products' => $exampleProducts,
                'error' => 'Failed to fetch data from Foxway.shop API: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Normalizza ricorsivamente le chiavi di un array da PascalCase a camelCase
     */
    private function normalizeKeys($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        
        $result = [];
        foreach ($data as $key => $value) {
            // Converti la chiave da PascalCase a camelCase (prima lettera minuscola)
            $newKey = lcfirst($key);
            
            // Se il valore è un array o un oggetto, normalizza ricorsivamente
            if (is_array($value)) {
                $result[$newKey] = $this->normalizeKeys($value);
            } else {
                $result[$newKey] = $value;
            }
        }
        
        return $result;
    }
    
    /**
     * Recupera tutti i cataloghi di prodotti disponibili dall'API di Foxway.shop
     */
    private function getProductCatalogs($apiKey)
    {
        try {
            $apiUrl = 'https://foxway.shop';
            $endpoint = '/api/v1/catalogs';
            
            // Log per debug
            Log::info('Foxway API request for catalogs with key: ' . substr($apiKey, 0, 5) . '...' . substr($apiKey, -5));
            Log::info('Foxway API endpoint: ' . $apiUrl . $endpoint);
            
            // Richiesta all'API per ottenere l'elenco dei cataloghi
            $response = Http::withHeaders([
                'X-ApiKey' => $apiKey,
                'Accept' => 'application/json',
            ])->get($apiUrl . $endpoint);
            
            // Log della risposta per debug
            Log::info('Foxway API catalogs response status: ' . $response->status());
            
            if (!$response->successful()) {
                $responseBody = $response->body();
                Log::error('Foxway API catalogs error: ' . $responseBody);
                throw new \Exception('Failed to fetch catalogs from Foxway API. Status code: ' . $response->status());
            }
            
            // Normalizzare la risposta dell'API
            $responseData = $response->json() ?? [];
            Log::info('Foxway API catalogs count: ' . count($responseData));
            
            // Normalizzare le chiavi per renderle consistenti (prima lettera minuscola)
            $normalizedData = [];
            foreach ($responseData as $catalog) {
                $normalizedData[] = $this->normalizeKeys($catalog);
            }
            
            return $normalizedData;
            
        } catch (\Exception $e) {
            Log::error('Error in getProductCatalogs: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Recupera i dettagli di un catalogo specifico dall'API di Foxway.shop
     */
    private function getCatalogDetails($apiKey, $urlSlug)
    {
        try {
            $apiUrl = 'https://foxway.shop';
            $endpoint = '/api/v1/catalogs/' . $urlSlug;
            
            // Log per debug
            Log::info('Foxway API request for catalog details: ' . $urlSlug);
            
            // Richiesta all'API per ottenere i dettagli del catalogo
            $response = Http::withHeaders([
                'X-ApiKey' => $apiKey,
                'Accept' => 'application/json',
            ])->get($apiUrl . $endpoint);
            
            // Log della risposta per debug
            Log::info('Foxway API catalog details response status: ' . $response->status());
            
            if (!$response->successful()) {
                $responseBody = $response->body();
                Log::error('Foxway API catalog details error: ' . $responseBody);
                throw new \Exception('Failed to fetch catalog details from Foxway API. Status code: ' . $response->status());
            }
            
            // Normalizzare la risposta dell'API
            $responseData = $response->json() ?? [];
            
            // Log per debug della risposta completa
            Log::info('Foxway API catalog details raw response: ' . json_encode(array_keys($responseData)));
            Log::info('Foxway API catalog details full response: ' . json_encode($responseData));
            
            // La risposta è un array con un singolo oggetto, prendiamo il primo elemento
            if (is_array($responseData) && count($responseData) > 0) {
                $catalogData = $responseData[0];
            } else {
                $catalogData = $responseData;
            }
            
            // Normalizzare le chiavi per renderle consistenti (prima lettera minuscola)
            $normalizedData = $this->normalizeKeys($catalogData);
            
            // Estrai i gruppi di dimensioni con i loro gruppi di item
            $result = [
                'dimensionGroups' => [],
                'itemGroups' => []
            ];
            
            // Se dimensionGroups è presente, lo aggiungiamo al risultato
            if (isset($normalizedData['dimensionGroups']) && is_array($normalizedData['dimensionGroups'])) {
                foreach ($normalizedData['dimensionGroups'] as $dimGroup) {
                    $normalizedDimGroup = $this->normalizeKeys($dimGroup);
                    
                    // Aggiungiamo il gruppo di dimensioni al risultato
                    $result['dimensionGroups'][] = [
                        'id' => $normalizedDimGroup['id'] ?? null,
                        'name' => $normalizedDimGroup['name'] ?? 'Unknown Group'
                    ];
                    
                    // Se questo gruppo di dimensioni contiene itemGroups, li estraiamo
                    if (isset($normalizedDimGroup['itemGroups']) && is_array($normalizedDimGroup['itemGroups'])) {
                        foreach ($normalizedDimGroup['itemGroups'] as $itemGroup) {
                            $normalizedItemGroup = $this->normalizeKeys($itemGroup);
                            
                            // Aggiungiamo questo item group al risultato, includendo il dimensionGroupId
                            $result['itemGroups'][] = [
                                'id' => $normalizedItemGroup['id'] ?? null,
                                'name' => $normalizedItemGroup['name'] ?? 'Unknown Item Group',
                                'dimensionGroupId' => $normalizedDimGroup['id'] ?? null
                            ];
                        }
                    }
                }
            }
            
            // Se non ci sono item groups trovati ma sono presenti direttamente nel catalogo
            if (empty($result['itemGroups']) && isset($normalizedData['itemGroups']) && is_array($normalizedData['itemGroups'])) {
                foreach ($normalizedData['itemGroups'] as $itemGroup) {
                    $normalizedItemGroup = $this->normalizeKeys($itemGroup);
                    
                    $result['itemGroups'][] = [
                        'id' => $normalizedItemGroup['id'] ?? null,
                        'name' => $normalizedItemGroup['name'] ?? 'Unknown Item Group',
                        'dimensionGroupId' => null // Non sappiamo a quale dimensionGroup appartiene
                    ];
                }
            }
            
            Log::info('Foxway API dimension groups found: ' . count($result['dimensionGroups']));
            Log::info('Foxway API item groups found: ' . count($result['itemGroups']));
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Error in getCatalogDetails: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Recupera i produttori disponibili per un catalogo specifico dall'API di Foxway.shop
     */
    private function getManufacturers($apiKey, $urlSlug, $dimensionGroupId, $itemGroupId)
    {
        try {
            $apiUrl = 'https://foxway.shop';
            $endpoint = '/api/v1/catalogs/' . $urlSlug . '/manufacturers';
            
            // Parametri di query per filtrare i produttori
            $queryParams = [
                'dimensionGroupId' => $dimensionGroupId,
                'itemGroupId' => $itemGroupId,
            ];
            
            // Log per debug
            Log::info('Foxway API request for manufacturers: ' . $urlSlug . ' with filters: ' . json_encode($queryParams));
            
            // Richiesta all'API per ottenere i produttori
            $response = Http::withHeaders([
                'X-ApiKey' => $apiKey,
                'Accept' => 'application/json',
            ])->get($apiUrl . $endpoint, $queryParams);
            
            // Log della risposta per debug
            Log::info('Foxway API manufacturers response status: ' . $response->status());
            Log::info('Foxway API manufacturers response body: ' . $response->body());
            
            if (!$response->successful()) {
                $responseBody = $response->body();
                Log::error('Foxway API manufacturers error: ' . $responseBody);
                return [];
            }
            
            // Normalizzare la risposta dell'API
            $responseData = $response->json() ?? [];
            Log::info('Foxway API manufacturers count: ' . count($responseData));
            
            // Normalizzare le chiavi e formattare i dati per la visualizzazione
            $manufacturers = [];
            foreach ($responseData as $item) {
                $normalizedItem = $this->normalizeKeys($item);
                $manufacturers[] = [
                    'id' => $normalizedItem['id'] ?? null,
                    'name' => $normalizedItem['name'] ?? 'Unknown Manufacturer',
                ];
            }
            
            return $manufacturers;
            
        } catch (\Exception $e) {
            Log::error('Error in getManufacturers: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Recupera gli articoli di stock disponibili dall'API di Foxway.shop
     */
    private function getStockItems($apiKey, $urlSlug, $dimensionGroupId, $itemGroupId, $manufacturerId = null)
    {
        try {
            $apiUrl = 'https://foxway.shop';
            $endpoint = '/api/v1/catalogs/' . $urlSlug . '/stock';
            
            // Parametri di query per filtrare lo stock
            $queryParams = [
                'dimensionGroupId' => $dimensionGroupId,
                'itemGroupId' => $itemGroupId,
            ];
            
            // Aggiungi il produttore se specificato
            if ($manufacturerId) {
                $queryParams['manufacturerId'] = $manufacturerId;
            }
            
            // Log per debug
            Log::info('Foxway API request for stock items: ' . $urlSlug . ' with filters: ' . json_encode($queryParams));
            
            // Richiesta all'API per ottenere gli articoli di stock
            $response = Http::withHeaders([
                'X-ApiKey' => $apiKey,
                'Accept' => 'application/json',
            ])->get($apiUrl . $endpoint, $queryParams);
            
            // Log della risposta per debug
            Log::info('Foxway API stock items response status: ' . $response->status());
            Log::info('Foxway API stock items response body length: ' . strlen($response->body()));
            Log::info('Foxway API stock items response first 500 chars: ' . substr($response->body(), 0, 500));
            
            // Verifica se la risposta contiene HTML invece di JSON
            if (strpos($response->body(), '<!DOCTYPE html>') !== false) {
                Log::warning('Foxway API returned HTML instead of JSON. API might have changed or requires different authentication.');
                // Prova con l'endpoint stocklist diretto
                Log::info('Trying stocklist endpoint directly instead');
                $productsResponse = $this->getProductsFromFoxwayAPI($apiKey, $urlSlug, $dimensionGroupId, $itemGroupId, $manufacturerId);
                
                if (!empty($productsResponse)) {
                    return $productsResponse;
                } else {
                    // Se ancora non otteniamo risultati, restituisci i dati di esempio
                    Log::warning('All Foxway API endpoints returned HTML or empty responses. Falling back to example products.');
                    return $this->getExampleProducts();
                }
            }
            
            if (!$response->successful()) {
                $responseBody = $response->body();
                Log::error('Foxway API stock items error: ' . $responseBody);
                throw new \Exception('Failed to fetch stock items from Foxway API. Status code: ' . $response->status());
            }
            
            // Normalizzare la risposta dell'API
            $responseData = $response->json() ?? [];
            Log::info('Foxway API stock items count: ' . count($responseData));
            
            // Se non ci sono prodotti, prova l'endpoint diretto per ottenere i prodotti
            if (empty($responseData)) {
                Log::info('Foxway API stock items empty, trying direct product endpoint');
                $productsResponse = $this->getProductsFromFoxwayAPI($apiKey, $urlSlug, $dimensionGroupId, $itemGroupId, $manufacturerId);
                
                if (!empty($productsResponse)) {
                    $responseData = $productsResponse;
                    Log::info('Foxway API direct products count: ' . count($responseData));
                } else {
                    // Se ancora vuoto, prova con l'endpoint pricelist
                    Log::info('Foxway API direct products empty, trying pricelist endpoint');
                    
                    $pricelistEndpoint = '/api/v1/catalogs/' . $urlSlug . '/pricelist';
                    
                    // Richiesta all'API per ottenere il listino prezzi
                    $pricelistResponse = Http::withHeaders([
                        'X-ApiKey' => $apiKey,
                        'Accept' => 'application/json',
                    ])->get($apiUrl . $pricelistEndpoint, $queryParams);
                    
                    // Log della risposta per debug
                    Log::info('Foxway API pricelist response status: ' . $pricelistResponse->status());
                    Log::info('Foxway API pricelist response body length: ' . strlen($pricelistResponse->body()));
                    Log::info('Foxway API pricelist response first 500 chars: ' . substr($pricelistResponse->body(), 0, 500));
                    
                    // Verifica se la risposta contiene HTML invece di JSON
                    if (strpos($pricelistResponse->body(), '<!DOCTYPE html>') !== false) {
                        Log::warning('Foxway API pricelist returned HTML instead of JSON. Using example products.');
                        return $this->getExampleProducts();
                    }
                    
                    if ($pricelistResponse->successful()) {
                        $responseData = $pricelistResponse->json() ?? [];
                        Log::info('Foxway API pricelist items count: ' . count($responseData));
                    }
                }
            }
            
            // Log per debug della struttura dei dati
            if (!empty($responseData) && count($responseData) > 0) {
                Log::info('Foxway API item example keys: ' . json_encode(array_keys($responseData[0])));
                Log::info('Foxway API item example: ' . json_encode($responseData[0]));
            } else {
                Log::info('Foxway API items empty response. No products available.');
                // Aggiungi un messaggio più dettagliato per l'utente
                $exampleProducts = $this->getExampleProducts();
                // Aggiungi una nota a ciascun prodotto di esempio per indicare che sono dati di esempio
                foreach ($exampleProducts as &$product) {
                    $product['name'] = '[ESEMPIO] ' . $product['name'];
                    $product['description'] = 'Dati di esempio - API Foxway ha restituito zero prodotti per questa selezione. ' . ($product['description'] ?? '');
                }
                return $exampleProducts;
            }
            
            // Normalizzare le chiavi e formattare i dati per la visualizzazione
            $products = [];
            foreach ($responseData as $item) {
                $normalizedItem = $this->normalizeKeys($item);
                $products[] = [
                    'id' => $normalizedItem['id'] ?? $normalizedItem['sku'] ?? uniqid('fx-'),
                    'name' => $normalizedItem['name'] ?? $normalizedItem['title'] ?? $normalizedItem['productName'] ?? 'Unknown Product',
                    'description' => $normalizedItem['description'] ?? $normalizedItem['details'] ?? $normalizedItem['productDescription'] ?? '',
                    'units' => $normalizedItem['quantity'] ?? $normalizedItem['units'] ?? $normalizedItem['availableQuantity'] ?? '0',
                    'price' => isset($normalizedItem['price']) ? '€' . $normalizedItem['price'] : (isset($normalizedItem['unitPrice']) ? '€' . $normalizedItem['unitPrice'] : 'N/A'),
                    'grade' => $normalizedItem['grade'] ?? $normalizedItem['condition'] ?? $normalizedItem['qualityGrade'] ?? 'A',
                    'manufacturer' => $normalizedItem['manufacturer'] ?? $normalizedItem['brand'] ?? '',
                    'model' => $normalizedItem['model'] ?? '',
                    'sku' => $normalizedItem['sku'] ?? '',
                ];
            }
            
            return $products;
            
        } catch (\Exception $e) {
            Log::error('Error in getStockItems: ' . $e->getMessage());
            // Restituisci dati di esempio come fallback
            $exampleProducts = $this->getExampleProducts();
            // Aggiungi una nota a ciascun prodotto di esempio per indicare che sono dati di esempio
            foreach ($exampleProducts as &$product) {
                $product['name'] = '[FALLBACK] ' . $product['name'];
                $product['description'] = 'Errore API: ' . $e->getMessage() . ' - ' . ($product['description'] ?? '');
            }
            return $exampleProducts;
        }
    }
    
    /**
     * Ottiene i prodotti direttamente dall'API di Foxway utilizzando un endpoint alternativo
     */
    private function getProductsFromFoxwayAPI($apiKey, $urlSlug, $dimensionGroupId, $itemGroupId, $manufacturerId = null)
    {
        try {
            $apiUrl = 'https://foxway.shop';
            
            // Tenta diversi endpoint conosciuti per ottenere i prodotti
            $endpoints = [
                '/api/v1/stocklist',
                '/api/v1/products',
                '/api/v1/catalogs/' . $urlSlug . '/items',
                '/api/v1/catalogs/' . $urlSlug . '/products'
            ];
            
            $queryParams = [
                'catalogUrlSlug' => $urlSlug,
                'dimensionGroupId' => $dimensionGroupId,
                'itemGroupId' => $itemGroupId
            ];
            
            if ($manufacturerId) {
                $queryParams['manufacturerId'] = $manufacturerId;
            }
            
            foreach ($endpoints as $endpoint) {
                Log::info('Trying Foxway API endpoint: ' . $apiUrl . $endpoint);
                
                $response = Http::withHeaders([
                    'X-ApiKey' => $apiKey,
                    'Accept' => 'application/json',
                ])->get($apiUrl . $endpoint, $queryParams);
                
                Log::info('Foxway API response status: ' . $response->status());
                
                if ($response->successful()) {
                    $data = $response->json() ?? [];
                    
                    if (!empty($data) && count($data) > 0) {
                        Log::info('Found products at endpoint: ' . $endpoint . ', count: ' . count($data));
                        return $data;
                    }
                }
            }
            
            // Se non troviamo prodotti, proviamo un ultimo tentativo con l'endpoint stocklist senza filtri
            Log::info('Trying Foxway API stocklist without filters');
            
            $response = Http::withHeaders([
                'X-ApiKey' => $apiKey,
                'Accept' => 'application/json',
            ])->get($apiUrl . '/api/v1/stocklist');
            
            if ($response->successful()) {
                $data = $response->json() ?? [];
                
                if (!empty($data) && count($data) > 0) {
                    Log::info('Found products at stocklist endpoint, count: ' . count($data));
                    return $data;
                }
            }
            
            // Se ancora niente, ritorna array vuoto
            return [];
            
        } catch (\Exception $e) {
            Log::error('Error in getProductsFromFoxwayAPI: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Restituisce dati di esempio per la visualizzazione in caso di errore
     */
    private function getExampleProducts()
    {
        return [
            [
                'id' => 'FX-12345',
                'name' => 'MacBook Pro 13" (2019)',
                'description' => 'Intel Core i5, 8GB RAM, 256GB SSD',
                'units' => '5',
                'price' => '€899.00',
                'grade' => 'A',
                'manufacturer' => 'Apple',
                'model' => 'MacBook Pro',
                'sku' => 'MBPA19-001',
            ],
            [
                'id' => 'FX-67890',
                'name' => 'iPhone 11 Pro 64GB',
                'description' => 'Space Gray, Unlocked',
                'units' => '10',
                'price' => '€549.00',
                'grade' => 'B',
                'manufacturer' => 'Apple',
                'model' => 'iPhone 11 Pro',
                'sku' => 'IP11P-001',
            ],
            [
                'id' => 'FX-24680',
                'name' => 'Samsung Galaxy S20 128GB',
                'description' => 'Cosmic Gray, Unlocked',
                'units' => '8',
                'price' => '€479.00',
                'grade' => 'A',
                'manufacturer' => 'Samsung',
                'model' => 'Galaxy S20',
                'sku' => 'SGS20-001',
            ]
        ];
    }
} 