<?php

namespace Modules\Controlpanel\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'controlpanel');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'controlpanel');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'controlpanel');
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
