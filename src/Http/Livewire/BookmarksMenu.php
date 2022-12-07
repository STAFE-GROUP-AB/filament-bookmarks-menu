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
use Livewire\Component;
use STAFEGROUPAB\FilamentBookmarksMenu\Facades\FilamentBookmarksMenu;

class BookmarksMenu extends Component
{
    public $menuitems;

    public function mount(): void
    {
        $this->menuitems = $this->getBookmarksMenuItems();
    }

    public function getBookmarksMenuItems()
    {
        // Get all global menu items
        $global_resources = \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::whereNull('menu_user_id')->orderBy('sort_order')->get();

        // Get all user specific menu items
        $user_resources = \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('menu_user_id', Auth::user()->id)->orderBy('sort_order')->get();

        // merge them into one collection for the Livewire component
        $all_menu_item = $global_resources->merge($user_resources);

        return $all_menu_item;
    }

    public function render(): View
    {
        return view('filament-bookmarks-menu::components.bookmarks-menu');
    }
}
