<?php

// Impostazioni iniziali
$apiKey = 'c9e4437f-f4fb-447a-8112-4641fb9e5a8e';
$apiUrl = 'https://foxway.shop';

// Parametri di test (sostituisci con valori reali dal tuo sistema)
$catalogUrlSlug = 'Mobiles'; // Esempio di valore, sostituisci con un valore reale dal tuo sistema
$dimensionGroupId = '1'; // Esempio di valore, sostituisci con un valore reale dal tuo sistema
$itemGroupId = '1'; // Esempio di valore, sostituisci con un valore reale dal tuo sistema

echo "=== TEST API FOXWAY.SHOP ===\n";
echo "Utilizzo API Key: " . substr($apiKey, 0, 5) . '...' . substr($apiKey, -5) . "\n";
echo "Catalog: $catalogUrlSlug\n";
echo "Dimension Group ID: $dimensionGroupId\n";
echo "Item Group ID: $itemGroupId\n\n";

// Funzione per effettuare richieste HTTP
function makeRequest($url, $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'body' => $response,
        'error' => $error
    ];
}

// Test 1: Ottenere tutti i cataloghi disponibili
echo "TEST 1: Ottenere tutti i cataloghi disponibili\n";
$headers = [
    'X-ApiKey: ' . $apiKey,
    'Accept: application/json'
];

$response = makeRequest($apiUrl . '/api/v1/catalogs', $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        echo "Cataloghi trovati: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "Primo catalogo:\n";
            print_r($data[0]);
            
            // Aggiorna il catalogUrlSlug con un valore reale dal sistema
            if (isset($data[0]['UrlSlug']) || isset($data[0]['urlSlug'])) {
                $catalogUrlSlug = $data[0]['UrlSlug'] ?? $data[0]['urlSlug'];
                echo "\nUsando catalog URL slug: $catalogUrlSlug\n";
            }
        }
    } else {
        echo "Errore nel parsing della risposta JSON\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n";

// Test 2: Ottenere i dettagli di un catalogo specifico
echo "TEST 2: Ottenere i dettagli del catalogo '$catalogUrlSlug'\n";
$response = makeRequest($apiUrl . '/api/v1/catalogs/' . $catalogUrlSlug, $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        if (is_array($data) && count($data) > 0) {
            // Se la risposta è un array, prendiamo il primo elemento
            $catalogData = $data[0] ?? $data;
        } else {
            $catalogData = $data;
        }
        
        // Cerchiamo i gruppi di dimensioni
        if (isset($catalogData['DimensionGroups']) || isset($catalogData['dimensionGroups'])) {
            $dimensionGroups = $catalogData['DimensionGroups'] ?? $catalogData['dimensionGroups'];
            echo "Gruppi di dimensioni trovati: " . count($dimensionGroups) . "\n";
            
            if (count($dimensionGroups) > 0) {
                echo "Primo gruppo di dimensioni:\n";
                print_r($dimensionGroups[0]);
                
                // Aggiorna dimensionGroupId con un valore reale
                if (isset($dimensionGroups[0]['Id']) || isset($dimensionGroups[0]['id'])) {
                    $dimensionGroupId = $dimensionGroups[0]['Id'] ?? $dimensionGroups[0]['id'];
                    echo "\nUsando dimension group ID: $dimensionGroupId\n";
                }
            }
        } else {
            echo "Nessun gruppo di dimensioni trovato\n";
        }
        
        // Cerchiamo i gruppi di articoli
        if (isset($catalogData['ItemGroups']) || isset($catalogData['itemGroups'])) {
            $itemGroups = $catalogData['ItemGroups'] ?? $catalogData['itemGroups'];
            echo "Gruppi di articoli trovati: " . count($itemGroups) . "\n";
            
            if (count($itemGroups) > 0) {
                echo "Primo gruppo di articoli:\n";
                print_r($itemGroups[0]);
                
                // Aggiorna itemGroupId con un valore reale
                if (isset($itemGroups[0]['Id']) || isset($itemGroups[0]['id'])) {
                    $itemGroupId = $itemGroups[0]['Id'] ?? $itemGroups[0]['id'];
                    echo "\nUsando item group ID: $itemGroupId\n";
                }
            }
        } else {
            echo "Nessun gruppo di articoli trovato\n";
        }
    } else {
        echo "Errore nel parsing della risposta JSON\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n";

// Test 3: Ottenere gli articoli di stock
echo "TEST 3: Ottenere gli articoli di stock per il catalogo '$catalogUrlSlug', dimension group '$dimensionGroupId', item group '$itemGroupId'\n";
$queryParams = http_build_query([
    'dimensionGroupId' => $dimensionGroupId,
    'itemGroupId' => $itemGroupId
]);

$response = makeRequest($apiUrl . '/api/v1/catalogs/' . $catalogUrlSlug . '/stock?' . $queryParams, $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        echo "Articoli di stock trovati: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "Primo articolo:\n";
            print_r($data[0]);
        }
    } else {
        echo "Errore nel parsing della risposta JSON o nessun prodotto trovato\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n";

// Test 4: Ottenere il listino prezzi
echo "TEST 4: Ottenere il listino prezzi per il catalogo '$catalogUrlSlug', dimension group '$dimensionGroupId', item group '$itemGroupId'\n";
$queryParams = http_build_query([
    'dimensionGroupId' => $dimensionGroupId,
    'itemGroupId' => $itemGroupId
]);

$response = makeRequest($apiUrl . '/api/v1/catalogs/' . $catalogUrlSlug . '/pricelist?' . $queryParams, $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        echo "Articoli nel listino prezzi trovati: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "Primo articolo:\n";
            print_r($data[0]);
        }
    } else {
        echo "Errore nel parsing della risposta JSON o nessun prodotto trovato\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n";

// Test 5: Ottenere prodotti con endpoint stocklist diretto
echo "TEST 5: Ottenere prodotti con endpoint stocklist diretto\n";
$response = makeRequest($apiUrl . '/api/v1/stocklist', $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        echo "Prodotti trovati: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "Primo prodotto:\n";
            print_r($data[0]);
        }
    } else {
        echo "Errore nel parsing della risposta JSON o nessun prodotto trovato\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n";

// Test 6: Endpoint items
echo "TEST 6: Ottenere items per il catalogo '$catalogUrlSlug', dimension group '$dimensionGroupId', item group '$itemGroupId'\n";
$queryParams = http_build_query([
    'dimensionGroupId' => $dimensionGroupId,
    'itemGroupId' => $itemGroupId
]);

$response = makeRequest($apiUrl . '/api/v1/catalogs/' . $catalogUrlSlug . '/items?' . $queryParams, $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        echo "Items trovati: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "Primo item:\n";
            print_r($data[0]);
        }
    } else {
        echo "Errore nel parsing della risposta JSON o nessun prodotto trovato\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n";

// Test 7: Endpoint products
echo "TEST 7: Ottenere products per il catalogo '$catalogUrlSlug', dimension group '$dimensionGroupId', item group '$itemGroupId'\n";
$queryParams = http_build_query([
    'catalogUrlSlug' => $catalogUrlSlug,
    'dimensionGroupId' => $dimensionGroupId,
    'itemGroupId' => $itemGroupId
]);

$response = makeRequest($apiUrl . '/api/v1/products?' . $queryParams, $headers);

echo "Status code: " . $response['code'] . "\n";
if ($response['error']) {
    echo "Error: " . $response['error'] . "\n";
} else {
    $data = json_decode($response['body'], true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        echo "Products trovati: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "Primo product:\n";
            print_r($data[0]);
        }
    } else {
        echo "Errore nel parsing della risposta JSON o nessun prodotto trovato\n";
        echo "Risposta: " . substr($response['body'], 0, 500) . "...\n";
    }
}

echo "\n=== FINE TEST ===\n"; 