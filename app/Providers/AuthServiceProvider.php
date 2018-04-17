<?php

namespace App\Providers;

use Adaojunior\Passport\SocialUserResolverInterface;
use App\Auth\SocialUserResolver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        Passport::routes();
    }

    public function register()
    {
        $this->app->singleton(
            SocialUserResolverInterface::class,
            SocialUserResolver::class
        );
    }
}
