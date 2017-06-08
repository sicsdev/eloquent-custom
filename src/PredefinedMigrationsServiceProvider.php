<?php

namespace Saritasa\Database\Eloquent;

use Illuminate\Support\ServiceProvider;

class PredefinedMigrationsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole())        {
            return;
        }
        $this->publishMigrations();
    }

    /**
     * Publish default migrations files
     */
    public function publishMigrations(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }
}
