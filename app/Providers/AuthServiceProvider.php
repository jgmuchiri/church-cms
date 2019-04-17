<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->role=='admin';
        });

        Gate::define('manager', function ($user) {
            return $user->role=='manager';
        });

        Gate::define('staff', function ($user) {
            return $user->role=='staff';
        });

        Gate::define('member', function ($user) {
            return $user->role=='member';
        });

        Gate::define('volunteer', function ($user) {
            return $user->role=='volunteer';
        });

        Gate::define('accountant', function ($user) {
            return $user->role=='accountant';
        });
    }
}
