<?php

namespace Database\Seeders;

use App\Models\ThirdPartySupplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ThirdPartySupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ITSale.pl
        ThirdPartySupplier::updateOrCreate(
            ['slug' => 'itsale-pl'],
            [
                'name' => 'ITSale.pl',
                'website' => 'https://itsale.pl',
                'description' => 'Poland-based B2B IT hardware supplier with a wide range of products.',
                'integration_type' => 'scraping',
                'logo' => 'supplier-logos/itsale-logo.png',
                'is_active' => false,
                'credentials' => [
                    'username' => '',
                    'password' => '',
                    'sync_frequency' => 'manual',
                    'auto_publish' => false,
                ],
            ]
        );

        // Foxway.shop
        ThirdPartySupplier::updateOrCreate(
            ['slug' => 'foxway-shop'],
            [
                'name' => 'Foxway.shop',
                'website' => 'https://foxway.shop',
                'description' => 'Estonia-based IT hardware and refurbished equipment supplier with API access.',
                'integration_type' => 'api',
                'logo' => 'supplier-logos/foxway-logo.png',
                'is_active' => false,
                'credentials' => [
                    'api_key' => '',
                    'sync_frequency' => 'manual',
                    'auto_publish' => false,
                ],
            ]
        );
    }
} 