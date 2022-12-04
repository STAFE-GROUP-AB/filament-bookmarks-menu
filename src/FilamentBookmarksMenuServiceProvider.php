<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use STAFEGROUPAB\FilamentBookmarksMenu\Commands\FilamentBookmarksMenuCommand;

class FilamentBookmarksMenuServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-bookmarks-menu')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament-bookmarks-menu_table')
            ->hasCommand(FilamentBookmarksMenuCommand::class);
    }
}
