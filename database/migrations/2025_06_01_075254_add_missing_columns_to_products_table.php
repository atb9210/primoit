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
        Schema::table('products', function (Blueprint $table) {
            // Add missing columns
            $table->string('name')->after('id')->nullable();
            $table->string('slug')->after('name')->unique()->nullable();
            $table->string('batch_number')->after('slug')->unique()->nullable();
            $table->text('description')->after('batch_number')->nullable();
            $table->enum('status', ['available', 'reserved', 'sold'])->after('price')->default('available');
            $table->enum('condition', ['new', 'refurbished', 'used'])->after('status')->default('used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove columns that were added
            $table->dropColumn(['name', 'slug', 'batch_number', 'description', 'status', 'condition']);
        });
    }
};
