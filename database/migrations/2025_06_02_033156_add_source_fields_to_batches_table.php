<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Aggiungi le colonne relative all'origine del batch solo se non esistono già
            if (!Schema::hasColumn('batches', 'source_type')) {
                $table->string('source_type')->nullable()->after('category_id')->default('internal'); // internal o external
            }
            
            if (!Schema::hasColumn('batches', 'supplier')) {
                $table->string('supplier')->nullable()->after('source_type'); // Nome del fornitore se external
            }
            
            if (!Schema::hasColumn('batches', 'external_reference')) {
                $table->string('external_reference')->nullable()->after('supplier'); // URL, numero ordine o riferimento esterno
            }
            
            // Aggiungi le colonne relative ai costi solo se non esistono già
            if (!Schema::hasColumn('batches', 'batch_cost')) {
                $table->decimal('batch_cost', 10, 2)->nullable()->default(0); // Costo del batch
            }
            
            if (!Schema::hasColumn('batches', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->nullable()->default(0); // Costo di spedizione
            }
            
            if (!Schema::hasColumn('batches', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->nullable()->default(0); // Importo tasse
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Rimuovi le colonne solo se esistono
            $columns = [
                'source_type',
                'supplier',
                'external_reference',
                'batch_cost',
                'shipping_cost',
                'tax_amount'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('batches', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

                $table->decimal('batch_cost', 10, 2)->nullable()->default(0); // Costo del batch
            }
            
            if (!Schema::hasColumn('batches', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->nullable()->default(0); // Costo di spedizione
            }
            
            if (!Schema::hasColumn('batches', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->nullable()->default(0); // Importo tasse
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Rimuovi le colonne solo se esistono
            $columns = [
                'source_type',
                'supplier',
                'external_reference',
                'batch_cost',
                'shipping_cost',
                'tax_amount'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('batches', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};