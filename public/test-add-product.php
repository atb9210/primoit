<?php

// Carica l'ambiente Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Autenticazione manuale
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Autenticarsi come admin
$credentials = [
    'email' => 'admin@primoit.com',
    'password' => 'Admin123!'
];

if (Auth::attempt($credentials)) {
    echo "Autenticazione riuscita come admin<br>";
} else {
    echo "Autenticazione fallita<br>";
    exit;
}

// Recupera il batch con ID 19
$batch = \App\Models\Batch::find(19);

if (!$batch) {
    echo "Batch non trovato<br>";
    exit;
}

echo "Batch trovato: " . $batch->name . " (ID: " . $batch->id . ")<br>";

// Dati del prodotto da aggiungere
$productData = [
    'manufacturer' => 'Lenovo',
    'model' => 'ThinkPad T470',
    'grade' => 'A',
    'price' => 798.00,
    'quantity' => 1,
    'tech_grade' => 'Working',
    'parameters' => [
        'OS' => 'Windows 10 Pro',
        'CPU' => 'Intel Core i5',
        'RAM' => '8GB',
        'Storage' => '256GB SSD',
    ],
    'images' => [],
    'created_at' => now()->toDateTimeString()
];

try {
    // Recupera i prodotti esistenti o inizializza un array vuoto
    $products = $batch->products ?? [];
    
    // Aggiungi il nuovo prodotto
    $products[] = $productData;
    
    // Aggiorna il batch con i nuovi prodotti
    $batch->products = $products;
    
    // Aggiorna anche il prezzo totale e la quantità
    $totalQuantity = 0;
    $totalPrice = 0;
    
    foreach ($products as $product) {
        $totalQuantity += $product['quantity'];
        $totalPrice += $product['price'] * $product['quantity'];
    }
    
    $batch->total_quantity = $totalQuantity;
    $batch->total_price = $totalPrice;
    
    $batch->save();
    
    echo "Prodotto aggiunto con successo!<br>";
    echo "Totale prodotti: " . count($products) . "<br>";
    echo "Quantità totale: " . $totalQuantity . "<br>";
    echo "Prezzo totale: " . $totalPrice . "<br>";
    
} catch (\Exception $e) {
    echo "Errore durante l'aggiunta del prodotto: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Linea: " . $e->getLine() . "<br>";
}

// Termina la risposta
$kernel->terminate($request, $response); 