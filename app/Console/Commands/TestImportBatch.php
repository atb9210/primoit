<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ITSaleScraperController;
use App\Models\ThirdPartySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestImportBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:import-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the import batch functionality';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting import batch test...');
        
        try {
            // Get the supplier
            $supplier = ThirdPartySupplier::where('name', 'ITSale.pl')->first();
            
            if (!$supplier) {
                $this->error('Supplier ITSale.pl not found!');
                return 1;
            }
            
            $this->info('Found supplier: ' . $supplier->name);
            
            // Create a test request
            $request = new Request([
                'batch_name' => 'Dell 8 Gen Laptops Test CMD',
                'batch_reference' => 'ITSALE-DELL-8-GEN-TEST-CMD',
                'batch_status' => 'active',
                'category_id' => 1,
                'batch_description' => 'Test batch import from command line',
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
            ]);
            
            // Create controller instance
            $controller = new ITSaleScraperController();
            
            // Call the import method
            $this->info('Calling importAsBatch method...');
            $response = $controller->importAsBatch($request, $supplier, 'dell-8-gen-laptops');
            
            // Check response
            if ($response instanceof \Illuminate\Http\RedirectResponse) {
                $this->info('Import successful! Redirect URL: ' . $response->getTargetUrl());
                
                // Get the URL segments to extract the batch ID
                $segments = explode('/', $response->getTargetUrl());
                $batchId = end($segments);
                
                // Find the batch
                $batch = \App\Models\Batch::find($batchId);
                if ($batch) {
                    $this->info('Batch created successfully:');
                    $this->table(
                        ['ID', 'Name', 'Reference', 'Status', 'Total Cost', 'Products Count'],
                        [[$batch->id, $batch->name, $batch->reference_code, $batch->status, $batch->total_cost, count($batch->products)]]
                    );
                    return 0;
                } else {
                    $this->error('Batch not found after import!');
                    return 1;
                }
            } else {
                $this->error('Import failed! Response is not a redirect.');
                $this->line('Response: ' . $response);
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error('Exception occurred: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            return 1;
        }
    }
} 