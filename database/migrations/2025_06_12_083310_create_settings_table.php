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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Chiave univoca per l\'impostazione');
            $table->text('value')->nullable()->comment('Valore dell\'impostazione');
            $table->string('group')->default('general')->comment('Gruppo di appartenenza dell\'impostazione');
            $table->string('type')->default('text')->comment('Tipo di dato (text, file, json, etc.)');
            $table->string('name')->comment('Nome visualizzato dell\'impostazione');
            $table->text('description')->nullable()->comment('Descrizione dell\'impostazione');
            $table->boolean('is_public')->default(false)->comment('Se l\'impostazione è pubblica o solo admin');
            $table->boolean('is_system')->default(false)->comment('Se l\'impostazione è di sistema e non modificabile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
