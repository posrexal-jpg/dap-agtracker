<?php

namespace App\Providers;

<<<<<<< HEAD
=======
use App\Models\ActivityLog;
use App\Models\ActivityType;
use App\Models\Location;
use App\Models\User;
>>>>>>> cfe5925bbedd2b2a05f4d904b6d23f3665016d7a
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

<<<<<<< HEAD
=======
        $audit = static function (string $label): void {
            $label::created(fn ($model) => ActivityLog::record('created', $model, class_basename($model) . ' created'));
            $label::updated(fn ($model) => ActivityLog::record('updated', $model, class_basename($model) . ' updated'));
            $label::deleted(fn ($model) => ActivityLog::record('deleted', $model, class_basename($model) . ' deleted'));
        };
        $audit(Location::class);
        $audit(User::class);
        $audit(ActivityType::class);

>>>>>>> cfe5925bbedd2b2a05f4d904b6d23f3665016d7a
        // Load helper that maps Vite manifest entries to built assets
        $helpers = app_path('Helpers/manifest.php');
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }
}
