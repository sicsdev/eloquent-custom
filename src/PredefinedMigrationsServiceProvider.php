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
        // default migrations files
        $this->publishes([
            __DIR__ . '/../database/migrations/2014_10_12_000000_create_users_table.php' => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            __DIR__ . '/../database/migrations/2015_01_15_105324_create_roles_table.php' => database_path('migrations/2015_01_15_105324_create_roles_table.php'),
            __DIR__ . '/../database/migrations/2015_01_15_114412_create_role_user_table.php' => database_path('migrations/2015_01_15_114412_create_role_user_table.php'),
            __DIR__ . '/../database/migrations/2015_01_26_115212_create_permissions_table.php' => database_path('migrations/2015_01_26_115212_create_permissions_table.php'),
            __DIR__ . '/../database/migrations/2015_01_26_115523_create_permission_role_table.php' => database_path('migrations/2015_01_26_115523_create_permission_role_table.php'),
            __DIR__ . '/../database/migrations/2015_02_09_132429_create_permission_user_table.php' => database_path('migrations/2015_02_09_132429_create_permission_user_table.php'),
        ], 'migrations');
    }
}
