<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        Gate::define('super-admin', fn($user) => $user->role === \App\Models\User::ROLE_SUPER_ADMIN && $user->is_active);
        Gate::define('moderate-content', fn($user) => in_array($user->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_MODERATOR]) && $user->is_active);
        Gate::define('edit-content', fn($user) => in_array($user->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_EDITOR]) && $user->is_active);
    }
}
