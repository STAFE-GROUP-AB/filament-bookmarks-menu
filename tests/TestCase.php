<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use STAFEGROUPAB\FilamentBookmarksMenu\FilamentBookmarksMenuServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'STAFEGROUPAB\\FilamentBookmarksMenu\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentBookmarksMenuServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-bookmarks-menu_table.php.stub';
        $migration->up();
        */
    }
}
