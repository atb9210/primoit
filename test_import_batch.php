<?php

// Bootstrap the application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a fake request to test the importAsBatch method
$request = Illuminate\Http\Request::create(
    '/admin/itsale/scraper/1/dell-8-gen-laptops/import-batch',
    'POST',
    [
        'batch_name' => 'Dell 8 Gen Laptops Test',
        'batch_reference' => 'ITSALE-DELL-8-GEN-TEST',
        'batch_status' => 'active',
        'category_id' => 1,
        'batch_description' => 'Test batch import Dell 8th Gen laptops',
        'source_type' => 'external',
        'supplier' => 'ITSale',
        'external_reference' => 'https://itsale.pl/list/dell-8-gen-laptops',
        'batch_cost' => 10000,
        'shipping_cost' => 200,
        'tax_amount' => 2000,
        'total_cost' => 12200,
        'confirm_import' => 1,
        'spec_fields' => ['Model', 'CPU', 'RAM'],
        'spec_params' => ['model', 'cpu', 'ram'],
        'spec_custom_params' => []
    ]
);

// Set the application in the request
$request->setLaravelSession($app['session']->driver());

try {
    // Get the controller
    $controller = new App\Http\Controllers\Admin\ITSaleScraperController();
    
    // Get the supplier
    $supplier = App\Models\ThirdPartySupplier::find(1);
    
    // Call the importAsBatch method
    $response = $controller->importAsBatch($request, $supplier, 'dell-8-gen-laptops');
    
    // Output the response
    if ($response instanceof Illuminate\Http\RedirectResponse) {
        echo "Import successful! Redirecting to: " . $response->getTargetUrl() . "\n";
    } else {
        echo "Response received but not a redirect.\n";
        var_dump($response);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
} 