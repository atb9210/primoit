<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ThirdPartySupplier;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creazione di un nuovo fornitore Foxway.shop Scraper
        ThirdPartySupplier::create([
            'name' => 'Foxway.shop Scraper',
            'slug' => 'foxway-shop-scraper',
            'website' => 'https://foxway.shop/WorkingPub',
            'description' => 'Web scraping integration for Foxway.shop WorkingPub interface',
            'integration_type' => 'scraping',
            'is_active' => true,
            'credentials' => [
                'username' => 'zarosrls@gmail.com',
                'password' => 'Logistica24',
                'login_url' => 'https://foxway.shop/Identity/Account/Login',
                'sync_frequency' => 'manual',
                'auto_publish' => false,
                'margin' => 20,
                'whatsapp' => '',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rimozione del fornitore Foxway.shop Scraper
        DB::table('third_party_suppliers')
            ->where('slug', 'foxway-shop-scraper')
            ->delete();
    }
};
