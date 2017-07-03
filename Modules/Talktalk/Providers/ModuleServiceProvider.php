<?php

namespace Modules\Talktalk\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'talktalk');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'talktalk');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'talktalk');
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
