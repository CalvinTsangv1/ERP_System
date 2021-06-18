<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        
        
        Gate::define('isAdmin', function($user) {
            return $user->postTitle == 'System Administrator';
        });
        Gate::define('isPM', function($user) {
            return $user->postTitle == 'Purchasing Manager';
        });  
        Gate::define('isRM', function($user) {
            return $user->postTitle == 'Restaurant Manager';
        });  
        Gate::define('isAM', function($user) {
            return $user->postTitle == 'Accounting Manager';
        });  
        Gate::define('isWC', function($user) {
            return $user->postTitle == 'Warehouse Clerk';
        });  
        Gate::define('isCM', function($user) {
            return $user->postTitle == 'Category Manager';
        });  
        
        
                           
    }
}
