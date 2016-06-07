<?php

namespace BenConstable\Localize;

use Illuminate\Support\ServiceProvider;

/**
 * This service provider registers the localize library.
 */
class LocalizeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  boolean
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return  void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/localize-middleware.php' => config_path('localize-middleware.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return  void
     */
    public function register()
    {
        $this->app->singleton(DeterminerManager::class, function ($app) {
            return new DeterminerManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return  array
     */
    public function provides()
    {
        return [
            DeterminerManager::class
        ];
    }
}
