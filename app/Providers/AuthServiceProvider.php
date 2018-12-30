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
        
        Gate::define('isDepositEmployee', function ($user) {
            return $user->user_role == 1 && $user->status_aktif == 1;
        });

          
        Gate::define('isLoanEmployee', function ($user) {
            return $user->user_role == 2 && $user->status_aktif == 1;
        });

        Gate::define('isAdmin', function ($user) {
            return $user->user_role == 3 && $user->status_aktif == 1;
        });
        //
    }
}
