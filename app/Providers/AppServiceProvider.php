<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        // Load helper that maps Vite manifest entries to built assets
        $helpers = app_path('Helpers/manifest.php');
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }
}
