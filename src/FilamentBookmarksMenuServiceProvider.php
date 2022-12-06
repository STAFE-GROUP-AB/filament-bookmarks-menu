<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu;

use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use STAFEGROUPAB\FilamentBookmarksMenu\Resources\BookmarksMenuResource;

class FilamentBookmarksMenuServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        BookmarksMenuResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-bookmarks-menu')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_filament_bookmarks_menu_table');
    }

    public function boot()
    {
        Livewire::component('bookmarks-menu', Http\Livewire\BookmarksMenu::class);

        if (config('filament-bookmarks-menu.add_bookmarks_by_users', true)) {
            Livewire::component('bookmarks-icon', Http\Livewire\BookmarksIcon::class);
        }

        Filament::registerRenderHook(
            'user-menu.start',
            fn (): string => Blade::render('@livewire(\'bookmarks-menu\')'),
        );
        if (config('filament-bookmarks-menu.add_bookmarks_by_users', true)) {
            Filament::registerRenderHook(
                'content.start',
                fn (): string => Blade::render('@livewire(\'bookmarks-icon\')'),
            );
        }
        parent::boot();
    }
}
