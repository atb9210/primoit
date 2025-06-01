<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.admin', 'admin-layout');
        Blade::component('components.admin-nav-link', 'admin-nav-link');
        Blade::component('components.admin-responsive-nav-link', 'admin-responsive-nav-link');
        
        // Custom directive for safely formatting prices
        Blade::directive('formatPrice', function ($expression) {
            return "<?php 
                try {
                    \$priceValue = '€0.00';
                    if (isset({$expression}) && {$expression} !== '' && {$expression} !== null) {
                        \$priceValue = '€' . number_format((float) {$expression}, 2, '.', ',');
                    }
                    echo \$priceValue;
                } catch (\\Exception \$e) {
                    echo '€0.00';
                }
            ?>";
        });
    }
}
