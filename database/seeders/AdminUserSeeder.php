<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@primoit.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
            'is_approved' => true,
            'company_name' => 'PrimoIT',
            'vat_number' => 'IT12345678901',
            'phone' => '+390123456789',
            'address' => 'Via Roma 1',
            'city' => 'Milano',
            'postal_code' => '20121',
            'country' => 'Italy',
            'email_verified_at' => now(),
        ]);
    }
} 