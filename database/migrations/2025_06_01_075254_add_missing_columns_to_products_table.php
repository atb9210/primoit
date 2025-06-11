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
        // Creiamo la tabella products se non esiste
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->string('batch_number')->nullable();
                $table->text('description')->nullable();
                $table->string('status')->default('active');
                $table->string('condition')->nullable();
                $table->timestamps();
            });
        } else {
            // Se la tabella esiste già, aggiungiamo le colonne mancanti
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'name')) {
                    $table->string('name')->nullable()->after('id');
                }
                if (!Schema::hasColumn('products', 'slug')) {
                    $table->string('slug')->nullable()->after('name');
                }
                if (!Schema::hasColumn('products', 'batch_number')) {
                    $table->string('batch_number')->nullable()->after('slug');
                }
                if (!Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable()->after('batch_number');
                }
                if (!Schema::hasColumn('products', 'status')) {
                    $table->string('status')->default('active')->after('description');
                }
                if (!Schema::hasColumn('products', 'condition')) {
                    $table->string('condition')->nullable()->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non facciamo nulla nel down per evitare di perdere dati
    }
};
