<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\ActivityType;
use App\Models\Location;
use App\Models\User;
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

        $audit = static function (string $label): void {
            $label::created(fn ($model) => ActivityLog::record('created', $model, class_basename($model) . ' created'));
            $label::updated(fn ($model) => ActivityLog::record('updated', $model, class_basename($model) . ' updated'));
            $label::deleted(fn ($model) => ActivityLog::record('deleted', $model, class_basename($model) . ' deleted'));
        };
        $audit(Location::class);
        $audit(User::class);
        $audit(ActivityType::class);

        // Load helper that maps Vite manifest entries to built assets
        $helpers = app_path('Helpers/manifest.php');
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }
}
