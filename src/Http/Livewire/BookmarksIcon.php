<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Http\Livewire;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Filament\Forms;
use Livewire\Component;

class BookmarksIcon extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public bool $isBookmarked = false;
    public string $currentUrl = '';
    public bool $exclude_page = false;

    public \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu $bookmarkMenu;
    public string $label;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('menu_label')->required()->label('Set label'),
        ];
    }
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
                ->title('Selected Bookmark deleted successfully from your personal menu')
                ->icon('heroicon-o-bookmark')
                ->iconColor('danger')
                ->send();
            $this->redirect($this->currentUrl);
        }
    }
    public function addBookmark() {
        $exists =  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('menu_url', $this->currentUrl)->where('menu_user_id', Auth::user()->id)->first();
        if (!$exists) {
            $bm = new \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu();
            $bm->menu_label = "sidan";
            $bm->menu_url = $this->currentUrl;
            $bm->sort_order = 0;
            $bm->menu_target = '_self';
            $bm->menu_user_id = Auth::user()->id;
            $bm->save();
            Notification::make()
                ->title('Bookmark added successfully to your personal menu')
                ->icon('heroicon-o-bookmark')
                ->iconColor('success')
                ->send();
            $this->redirect($this->currentUrl);
        }
    }
    public function render(): View
    {
        return view('filament-bookmarks-menu::components.bookmarks-icon');
    }
}
