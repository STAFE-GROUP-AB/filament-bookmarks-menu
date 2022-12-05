<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Http\Livewire;

use Filament\Forms\ComponentContainer;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Cancel;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use STAFEGROUPAB\FilamentBookmarksMenu\Facades\FilamentBookmarksMenu;

class BookmarksIcon extends Page
{
    public $resources;

    public function mount(): void
    {

    }

    public function deleteBookmark($recordId) {
        \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('id', $recordId)->first()->delete();
        Notification::make()
            ->title('Selected Bookmark deleted successfully from your personal menu')
            ->icon('heroicon-o-bookmark')
            ->iconColor('danger')
            ->send();
    }

    public function render(): View
    {
        return view('filament-bookmarks-menu::components.bookmarks-icon');
    }
}
