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
        // Verifica se la tabella batches esiste prima di tentare di modificarla
        if (Schema::hasTable('batches')) {
            Schema::table('batches', function (Blueprint $table) {
                if (!Schema::hasColumn('batches', 'products')) {
                    $table->json('products')->nullable()->comment('Array JSON di prodotti all\'interno del batch')->after('specifications');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Verifica se la tabella batches esiste prima di tentare di modificarla
        if (Schema::hasTable('batches')) {
            Schema::table('batches', function (Blueprint $table) {
                if (Schema::hasColumn('batches', 'products')) {
                    $table->dropColumn('products');
                }
            });
        }
    }
}; 