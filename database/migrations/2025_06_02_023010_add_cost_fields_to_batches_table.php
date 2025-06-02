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
            $table->decimal('batch_cost', 10, 2)->nullable()->after('source_reference');
            $table->decimal('shipping_cost', 10, 2)->nullable()->after('batch_cost');
            $table->decimal('tax_amount', 10, 2)->nullable()->after('shipping_cost');
            $table->decimal('total_cost', 10, 2)->nullable()->after('tax_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['batch_cost', 'shipping_cost', 'tax_amount', 'total_cost']);
        });
    }
};
