<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu;

use Filament\Facades\Filament;
use Filament\Pages\Page;
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

        Livewire::listen('component.hydrate.initial', function ($component, $request) {
            if (! $component instanceof Page) {
                return;
            }

            app()->bind('page-title', fn () => invade($component)->getTitle());
        });

        if (config('filament-bookmarks-menu.add_bookmarks_by_users', true)) {
            Filament::registerRenderHook(
                'content.start',
                fn (): string => Blade::render('@livewire("bookmarks-icon")'),
            );
        }
        // Blade::render('@livewire("bookmarks-icon", ["title" => $this->getTitle()])')
        parent::boot();
    }
}
