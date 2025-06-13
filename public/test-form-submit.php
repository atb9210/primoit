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

// Simula l'invio del form
try {
    // Crea una richiesta simulata
    $formData = [
        '_token' => csrf_token(),
        'manufacturer' => 'Lenovo',
        'model' => 'ThinkPad T470',
        'grade' => 'A',
        'price' => 798.00,
        'quantity' => 1,
        'tech_grade' => 'Working',
        'param_keys' => ['OS', 'CPU', 'RAM', 'Storage'],
        'param_values' => ['Windows 10 Pro', 'Intel Core i5', '8GB', '256GB SSD']
    ];
    
    // Chiamata diretta al controller
    $controller = new \App\Http\Controllers\Admin\BatchController();
    
    // Crea una richiesta con i dati del form
    $request = new Illuminate\Http\Request();
    $request->merge($formData);
    
    // Imposta l'utente autenticato
    $request->setUserResolver(function () {
        return Auth::user();
    });
    
    // Esegui il metodo addProduct
    $response = $controller->addProduct($request, $batch);
    
    echo "Richiesta inviata con successo!<br>";
    echo "Risposta: " . get_class($response) . "<br>";
    
    // Se è un redirect, mostra l'URL
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        echo "Redirect a: " . $response->getTargetUrl() . "<br>";
    }
    
} catch (\Exception $e) {
    echo "Errore durante l'invio del form: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Linea: " . $e->getLine() . "<br>";
    echo "Trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

// Termina la risposta
$kernel->terminate($request, $response); 