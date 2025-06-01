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
                    // Evaluate the expression first, then check if it's valid
                    \$priceValue = {$expression};
                    if (\$priceValue !== null && \$priceValue !== '') {
                        echo '€' . number_format((float) \$priceValue, 2, '.', ',');
                    } else {
                        echo '€0.00';
                    }
                } catch (\\Exception \$e) {
                    echo '€0.00';
                }
            ?>";
        });
    }
}
