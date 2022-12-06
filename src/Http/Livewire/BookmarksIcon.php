<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Http\Livewire;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\View\View;

class BookmarksIcon extends Page
{

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
