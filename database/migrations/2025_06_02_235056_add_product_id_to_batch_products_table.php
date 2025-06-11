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
        // Non facciamo nulla, poiché questa migrazione è specifica per SQLite
        // e abbiamo già gestito la creazione della tabella products
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non facciamo nulla nel down, poiché rimuovere gli ID potrebbe causare problemi
    }
};

