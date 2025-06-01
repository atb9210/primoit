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
        // First drop the unique indexes
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_batch_number_unique');
            $table->dropUnique('products_slug_unique');
        });

        // Then modify the columns
        Schema::table('products', function (Blueprint $table) {
            // Drop existing columns
            $table->dropColumn([
                'batch_number',
                'name',
                'slug',
                'description',
                'min_order_quantity',
                'status',
                'condition',
                'has_product_list',
                'product_list_url',
            ]);

            // Add new columns
            $table->string('type')->after('id');
            $table->string('producer')->after('type');
            $table->string('model')->after('producer');
            $table->string('cpu')->nullable()->after('model');
            $table->string('ram')->nullable()->after('cpu');
            $table->string('drive')->nullable()->after('ram');
            $table->string('operating_system')->nullable()->comment('COA')->after('drive');
            $table->string('gpu')->nullable()->after('operating_system');
            $table->boolean('has_box')->default(false)->after('gpu');
            $table->string('color')->nullable()->after('has_box');
            $table->string('screen_size')->nullable()->after('color');
            $table->string('lcd_quality')->nullable()->after('screen_size');
            $table->string('battery')->nullable()->after('lcd_quality');
            $table->string('visual_grade')->nullable()->after('battery');
            $table->text('info')->nullable()->after('visual_grade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'type',
                'producer',
                'model',
                'cpu',
                'ram',
                'drive',
                'operating_system',
                'gpu',
                'has_box',
                'color',
                'screen_size',
                'lcd_quality',
                'battery',
                'visual_grade',
                'info',
            ]);

            // Restore original columns
            $table->string('batch_number');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->integer('min_order_quantity')->default(1);
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->enum('condition', ['new', 'refurbished', 'used'])->default('used');
            $table->boolean('has_product_list')->default(false);
            $table->string('product_list_url')->nullable();
            
            // Restore unique indexes
            $table->unique('batch_number');
            $table->unique('slug');
        });
    }
};
