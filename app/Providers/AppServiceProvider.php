<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
        // Usar Bootstrap 5 para paginación
        Paginator::useBootstrapFive();

        Relation::morphMap([
            'product' => Product::class,
            'service' => Service::class,
        ]);

        // Define Gates for permissions
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        foreach (User::PERMISSIONS as $permission) {
            Gate::define($permission, function (User $user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        }
    }
}
