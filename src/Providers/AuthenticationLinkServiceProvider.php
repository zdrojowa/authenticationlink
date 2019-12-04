<?php

namespace Zdrojowa\AuthenticationLink\Providers;

use Zdrojowa\AuthenticationLink\AuthenticationLink;
use Zdrojowa\AuthenticationLink\Contracts\AuthenticationLinkContract;
use Zdrojowa\AuthenticationLink\Models\AuthenticationLink as AuthenticationLinkModel;
use Zdrojowa\AuthenticationLink\Observers\AuthenticationLinkObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AuthenticationLinkServiceProvider extends ServiceProvider
{

    public array $bindings = [
        AuthenticationLinkContract::class => AuthenticationLink::class,
    ];

    public array $singletons = [
        'authentication_link' => AuthenticationLinkContract::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../Config/authentication-link.php' => config_path('authentication-link.php'),
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/authentication-link.php', 'authentication-link');

        if (Config::get('authentication-link.migrations')) $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        AuthenticationLinkModel::observe(AuthenticationLinkObserver::class);
    }
}
