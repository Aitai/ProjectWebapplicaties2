<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Gate::define('admin', fn($user) => $user->role == User::USER_ROLE_ADMIN);
        Gate::define('user',fn($user) => $user->role == User::USER_ROLE_USER);
        Gate::define('station',fn($user) => $user->role == User::USER_ROLE_USER);
        Gate::define('manage-maintenances', fn($user, $model) => $user->maintenances()->pluck('id')->contains($model->id) || Gate::check('admin'));
        Gate::define('manage-stations', fn($user, $model) => $user->stations()->pluck('id')->contains($model->id) || Gate::check('admin'));
    }
}
