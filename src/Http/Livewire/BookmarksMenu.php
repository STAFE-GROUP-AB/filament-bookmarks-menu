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

class BookmarksMenu extends Page
{
    public $resources;

    public function mount(): void
    {
        $this->resources = $this->getFilamentResources();
    }

    public function deleteBookmark($recordId) {
        \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('id', $recordId)->first()->delete();
        Notification::make()
            ->title('Selected Bookmark deleted successfully from your personal menu')
            ->icon('heroicon-o-bookmark')
            ->iconColor('danger')
            ->send();
    }
    protected function getActions(): array
    {
        if ($this->resources) {
            return collect($this->resources)
                ->filter(function ($item) {
                    return $item['url'] === null;
                })
                ->transform(function ($item) {
                    $resource = App::make($item['resource_name']);
                    $listResource = invade(App::make($resource->getPages()['index']['class']));
                    $form = $listResource->getCreateFormSchema();

                    return CreateAction::make($item['action_name'])
                        ->model($resource->getModel())
                        ->form($form);
                })
                ->values()
                ->toArray();
        }

        return [];
    }

    public function callMountedAction(?string $arguments = null)
    {
        $action = $this->getMountedAction();

        if (! $action) {
            return;
        }

        if ($action->isDisabled()) {
            return;
        }

        $action->arguments($arguments ? json_decode($arguments, associative: true) : []);

        $form = $this->getMountedActionForm();

        $result = null;

        try {
            if ($action->hasForm()) {
                $action->callBeforeFormValidated();

                $action->formData($form->getState());

                $action->callAfterFormValidated();
            }

            $action->callBefore();

            $result = $action->call([
                'form' => $form,
            ]);

            $result = $action->callAfter() ?? $result;
        } catch (Halt $exception) {
            return;
        } catch (Cancel $exception) {
        }

        $this->mountedAction = null;

        $action->resetArguments();
        $action->resetFormData();

        $this->dispatchBrowserEvent('close-modal', [
            'id' => 'quick-create-action',
        ]);

        return $result;
    }

    public function mountAction(string $name)
    {
        $this->mountedAction = $name;

        $action = $this->getMountedAction();

        if (! $action) {
            return;
        }

        if ($action->isDisabled()) {
            return;
        }

        $this->cacheForm(
            'mountedActionForm',
            fn () => $this->getMountedActionForm(),
        );

        try {
            if ($action->hasForm()) {
                $action->callBeforeFormFilled();
            }

            $action->mount([
                'form' => $this->getMountedActionForm(),
            ]);

            if ($action->hasForm()) {
                $action->callAfterFormFilled();
            }
        } catch (Halt $exception) {
            return;
        } catch (Cancel $exception) {
            $this->mountedAction = null;

            return;
        }

        if (! $action->shouldOpenModal()) {
            return $this->callMountedAction();
        }

        $this->resetErrorBag();

        $this->dispatchBrowserEvent('open-modal', [
            'id' => 'quick-create-action',
        ]);
    }

    public function getMountedActionForm(): ?ComponentContainer
    {
        $action = $this->getMountedAction();

        if (! $action) {
            return null;
        }

        if ((! $this->isCachingForms) && $this->hasCachedForm('mountedActionForm')) {
            return $this->getCachedForm('mountedActionForm');
        }

        return $this->makeForm()
            ->schema($action->getFormSchema())
            ->statePath('mountedActionData')
            ->model($action->getModel())
            ->context($this->mountedAction);
    }

    public function getFilamentResources()
    {
        $global_resources = \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::whereNull('menu_user_id')->orderBy('sort_order')

            ->get();

        $user_resources = \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu::where('menu_user_id', Auth::user()->id)->orderBy('sort_order')

            ->get();

        $all_menu_item = $global_resources->merge($user_resources);


        return $all_menu_item;
    }

    public function render(): View
    {
        return view('filament-bookmarks-menu::components.bookmarks-menu');
    }
}
