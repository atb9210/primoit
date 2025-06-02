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
            // Campi principali per identificare il tipo di prodotto
            $table->string('product_type')->nullable()->after('reference_code')->comment('Tipo di prodotto: laptop, smartphone, hdd, etc.');
            $table->string('product_manufacturer')->nullable()->after('product_type')->comment('Produttore: Dell, HP, Apple, etc.');
            $table->string('product_model')->nullable()->after('product_manufacturer')->comment('Modello specifico del prodotto');
            
            // Campi per quantità di unità e prezzo unitario
            $table->integer('unit_quantity')->default(1)->after('total_quantity')->comment('Numero di unità in questo batch');
            $table->decimal('unit_price', 10, 2)->nullable()->after('unit_quantity')->comment('Prezzo per unità');
            
            // Attributi tecnici generici serializzati per vari tipi di prodotto
            $table->json('specifications')->nullable()->after('unit_price')->comment('Specifiche tecniche in formato JSON');
            
            // Attributi specifici per laptop/computer
            $table->string('cpu')->nullable()->after('specifications')->comment('Processore');
            $table->string('ram')->nullable()->after('cpu')->comment('Memoria RAM');
            $table->string('storage')->nullable()->after('ram')->comment('Tipo e capacità storage');
            $table->string('gpu')->nullable()->after('storage')->comment('Scheda grafica');
            $table->string('os')->nullable()->after('gpu')->comment('Sistema operativo');
            $table->string('screen_size')->nullable()->after('os')->comment('Dimensione schermo');
            $table->string('screen_resolution')->nullable()->after('screen_size')->comment('Risoluzione schermo');
            
            // Attributi specifici per smartphone/tablet
            $table->string('internal_memory')->nullable()->after('screen_resolution')->comment('Memoria interna');
            $table->string('camera')->nullable()->after('internal_memory')->comment('Fotocamera');
            $table->string('battery_capacity')->nullable()->after('camera')->comment('Capacità batteria');
            
            // Attributi specifici per dischi rigidi
            $table->string('hdd_capacity')->nullable()->after('battery_capacity')->comment('Capacità disco');
            $table->string('hdd_type')->nullable()->after('hdd_capacity')->comment('Tipo disco: SSD, HDD, etc.');
            $table->string('hdd_interface')->nullable()->after('hdd_type')->comment('Interfaccia: SATA, NVMe, etc.');
            
            // Attributi per lo stato fisico del prodotto
            $table->string('condition_grade')->nullable()->after('hdd_interface')->comment('Grado di condizione: A, B, C, etc.');
            $table->string('visual_grade')->nullable()->after('condition_grade')->comment('Grado estetico');
            $table->text('notes')->nullable()->after('visual_grade')->comment('Note aggiuntive');
            
            // Immagini serializzate
            $table->json('images')->nullable()->after('notes')->comment('Array di URL o percorsi di immagini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn([
                'product_type',
                'product_manufacturer',
                'product_model',
                'unit_quantity',
                'unit_price',
                'specifications',
                'cpu',
                'ram',
                'storage',
                'gpu',
                'os',
                'screen_size',
                'screen_resolution',
                'internal_memory',
                'camera',
                'battery_capacity',
                'hdd_capacity',
                'hdd_type',
                'hdd_interface',
                'condition_grade',
                'visual_grade',
                'notes',
                'images'
            ]);
        });
    }
};
