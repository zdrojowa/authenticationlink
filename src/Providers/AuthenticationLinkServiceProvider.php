<?php

namespace Zdrojowa\AuthenticationLink\Providers;

use Illuminate\Support\Facades\Route;
use Zdrojowa\AuthenticationLink\AuthenticationLink;
use Zdrojowa\AuthenticationLink\Console\Commands\AuthenticationLinkInstallCommand;
use Zdrojowa\AuthenticationLink\Contracts\AuthenticationLinkContract;
use Zdrojowa\AuthenticationLink\DataType\Registry;
use Zdrojowa\AuthenticationLink\Facades\AuthenticationLink as AuthenticationLinkFacade;
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
        $this->publishes([__DIR__ . '/../Config/metable.php' => config_path('metable.php'),], 'config');

        $this->registerDataTypeRegistry();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/authentication-link.php', 'authentication-link');
        $this->mergeConfigFrom(__DIR__ . '/../Config/metable.php', 'metable');

        if (AuthenticationLinkFacade::canMigrate()) $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        Config::set('auth.providers.users.model', \Zdrojowa\AuthenticationLink\Models\User::class);
        Config::set('hashing.driver', 'argon2id');

        AuthenticationLinkModel::observe(AuthenticationLinkObserver::class);

        $this->registerRoutes();
    }

    public function registerRoutes()
    {
        Route::get('/zdrojowa/authentication-link/{token}', 'Zdrojowa\AuthenticationLink\Http\Controllers\AuthenticationLinkController@login')->middleware('web')->name('authentication-link.login');
    }

    /**
     * Add the DataType Registry to the service container.
     *
     * @return void
     */
    protected function registerDataTypeRegistry(): void
    {
        $this->app->singleton(Registry::class, function() {
            $registry = new Registry();
            foreach (config('metable.datatypes') as $handler) {
                $registry->addHandler(new $handler());
            }

            return $registry;
        });
        $this->app->alias(Registry::class, 'metable.datatype.registry');
    }
}
