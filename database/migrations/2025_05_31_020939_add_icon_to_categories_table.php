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
        Schema::table('categories', function (Blueprint $table) {
            $table->text('icon_svg')->nullable()->after('description');
            $table->string('icon_image')->nullable()->after('icon_svg');
            $table->json('attributes')->nullable()->after('icon_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('icon_svg');
            $table->dropColumn('icon_image');
            $table->dropColumn('attributes');
        });
    }
};
