<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Filament\Forms;
use Livewire\Component;


class BookmarksIcon extends Component
{
    use Forms\Concerns\InteractsWithForms;

    public bool $isBookmarked = false;
    public string $currentUrl = '';
    public bool $exclude_page = false;
    public string $pageTitle;

    public function mount(): void
    {
        $this->getBookmarkedPage();
        if (is_array(config('filament-bookmarks-menu.exclude_pages'))) {
            $exclussions = config('filament-bookmarks-menu.exclude_pages');
            foreach ($exclussions as $exclusion) {
                if (basename($this->currentUrl) == $exclusion){
                    $this->exclude_page = true;
                    break;
                }
            }
        }
        $this->pageTitle = app('page-title');
        //$this->pageTitle = 'sidans titel';
    }
    public function getBookmarkedPage() {
        $pageUrl = ENV('APP_URL') . $_SERVER['REQUEST_URI'];
        $this->currentUrl = $pageUrl;
        $exists =  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('menu_url', $pageUrl)->where('menu_user_id', Auth::user()->id)->first();
        if ($exists) {
            $this->isBookmarked = true;
        } else {
            $this->isBookmarked = false;
        }
    }
    public function removeBookmark() {
        $exists =  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('menu_url', $this->currentUrl)->where('menu_user_id', Auth::user()->id)->first();
        if ($exists) {
            $exists->delete();
            Notification::make()
                ->title(__('filament-bookmarks-menu::filament-bookmarks-menu.notification.remove'))
                ->icon(config('filament-bookmarks-menu.notification_remove_icon'))
                ->iconColor(config('filament-bookmarks-menu.notification_remove_color'))
                ->send();
            $this->redirect($this->currentUrl);
        }
    }
    public function addBookmark() {
        $exists =  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('menu_url', $this->currentUrl)->where('menu_user_id', Auth::user()->id)->first();
        if (!$exists) {
            $bm = new \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu();
            $bm->menu_label = $this->pageTitle;
            $bm->menu_url = $this->currentUrl;
            $bm->sort_order = 0;
            $bm->menu_target = '_self';
            $bm->menu_user_id = Auth::user()->id;
            $bm->save();
            Notification::make()
                ->title(__('filament-bookmarks-menu::filament-bookmarks-menu.notification.add'))
                ->icon(config('filament-bookmarks-menu.notification_add_icon'))
                ->iconColor(config('filament-bookmarks-menu.notification_add_color'))
                ->send();
            $this->redirect($this->currentUrl);
        }
    }

    public function render(): View
    {
        return view('filament-bookmarks-menu::components.bookmarks-icon');
    }
}
