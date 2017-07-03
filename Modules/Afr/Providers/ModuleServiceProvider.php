<?php

namespace Modules\Afr\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'afr');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'afr');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'afr');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
