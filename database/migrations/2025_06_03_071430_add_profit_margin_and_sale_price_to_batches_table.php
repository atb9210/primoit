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
            if (!Schema::hasColumn('batches', 'profit_margin')) {
                $table->decimal('profit_margin', 8, 2)->default(16.00)->after('total_cost');
            }
            if (!Schema::hasColumn('batches', 'sale_price')) {
                $table->decimal('sale_price', 15, 2)->nullable()->after('profit_margin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'profit_margin')) {
                $table->dropColumn('profit_margin');
            }
            if (Schema::hasColumn('batches', 'sale_price')) {
                $table->dropColumn('sale_price');
            }
        });
    }
};
