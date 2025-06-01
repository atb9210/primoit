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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('quantity');
            $table->integer('min_order_quantity')->default(1);
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->enum('condition', ['new', 'refurbished', 'used'])->default('used');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->boolean('has_product_list')->default(false);
            $table->string('product_list_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
