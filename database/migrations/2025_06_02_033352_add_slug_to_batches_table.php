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
            // Aggiungi colonna slug se non esiste già
            if (!Schema::hasColumn('batches', 'slug')) {
                $table->string('slug')->nullable()->after('name')->index();
            }
            
            // Aggiungi colonna total_units se non esiste già
            if (!Schema::hasColumn('batches', 'total_units')) {
                $table->integer('total_units')->nullable()->default(0);
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
            if (Schema::hasColumn('batches', 'slug')) {
                $table->dropColumn('slug');
            }
            
            if (Schema::hasColumn('batches', 'total_units')) {
                $table->dropColumn('total_units');
            }
        });
    }
};
