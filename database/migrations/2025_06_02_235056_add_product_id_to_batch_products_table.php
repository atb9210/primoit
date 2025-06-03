<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Batch;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aggiorna i batch esistenti
        $this->updateExistingBatches();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non facciamo nulla nel down, poiché rimuovere gli ID potrebbe causare problemi
    }

    /**
     * Aggiorna i batch esistenti aggiungendo un ID univoco a ogni prodotto
     */
    private function updateExistingBatches(): void
    {
        $batches = Batch::whereNotNull('products')->get();
        
        foreach ($batches as $batch) {
            $products = $batch->products;
            
            if (is_array($products) && !empty($products)) {
                $updated = false;
                
                foreach ($products as $index => $product) {
                    // Verifica se il prodotto è un array valido
                    if (is_array($product)) {
                        // Verifica se l'ID è già presente
                        if (!isset($product['id'])) {
                            // Aggiungi un ID nel formato REFCODE-INDEX
                            $refCode = $batch->reference_code ?? 'BATCH-' . $batch->id;
                            $products[$index]['id'] = $refCode . '-' . ($index + 1);
                            $updated = true;
                        }
                    }
                }
                
                if ($updated) {
                    // Aggiorna il batch con i prodotti modificati
                    $batch->products = $products;
                    $batch->save();
                }
            }
        }
    }
};

     */
    private function updateExistingBatches(): void
    {
        $batches = Batch::whereNotNull('products')->get();
        
        foreach ($batches as $batch) {
            $products = $batch->products;
            
            if (is_array($products) && !empty($products)) {
                $updated = false;
                
                foreach ($products as $index => $product) {
                    // Verifica se il prodotto è un array valido
                    if (is_array($product)) {
                        // Verifica se l'ID è già presente
                        if (!isset($product['id'])) {
                            // Aggiungi un ID nel formato REFCODE-INDEX
                            $refCode = $batch->reference_code ?? 'BATCH-' . $batch->id;
                            $products[$index]['id'] = $refCode . '-' . ($index + 1);
                            $updated = true;
                        }
                    }
                }
                
                if ($updated) {
                    // Aggiorna il batch con i prodotti modificati
                    $batch->products = $products;
                    $batch->save();
                }
            }
        }
    }
};
