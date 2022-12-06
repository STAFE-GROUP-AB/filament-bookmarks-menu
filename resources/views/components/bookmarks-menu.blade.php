<div class="flex justify-end">
    @if ($resources)
        <x-filament::dropdown placement="bottom-end">
            <x-slot name="trigger" class="ml-4">
                <button  @class([
                'flex flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 items-center justify-center',
                'dark:bg-gray-900' => config('filament.dark_mode'),
            ]) aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
                    @svg('heroicon-o-bookmark', 'w-4 h-4')
                </button>
            </x-slot>
            <x-filament::dropdown.list>
                <p class="pl-2 text-gray-600 text-sm border-b">{{ __('filament-bookmarks-menu::filament-bookmarks-menu.label.global') }}</p>
                @foreach($resources->whereNull('menu_user_id') as $resource)
                    <x-filament::dropdown.item
                        :color="'secondary'"
                        icon=""
                        :href="$resource['menu_url']"
                        :target="$resource['menu_target']"
                        :tag="$resource['menu_url'] ? 'a' : 'button'"
                    >
                        {{ $resource['menu_label'] }}
                    </x-filament::dropdown.item>
                @endforeach

                <p class="pl-2 text-gray-600 text-sm border-b">{{ __('filament-bookmarks-menu::filament-bookmarks-menu.label.private') }}</p>
                @foreach($resources->whereNotNull('menu_user_id') as $resource)
                    <x-filament::dropdown.item
                        :color="'secondary'"
                        icon=""
                        :href="$resource['menu_url']"
                        :target="$resource['menu_target']"
                        action="Create"
                        :tag="$resource['menu_url'] ? 'a' : 'button'"
                    >
                      {{ $resource['menu_label'] }}
                    </x-filament::dropdown.item>
                @endforeach
            </x-filament::dropdown.list>
        </x-filament::dropdown>

        <form wire:submit.prevent="callMountedAction">
            @php
                $action = $this->getMountedAction();
            @endphp

            <x-filament::modal
                id="quick-create-action"
                :wire:key="$action ? $this->id . '.actions.' . $action->getName() . '.modal' : null"
                :visible="filled($action)"
                :width="$action?->getModalWidth()"
                :slide-over="$action?->isModalSlideOver()"
                display-classes="block"
            >
                @if ($action)
                    @if ($action->isModalCentered())
                        <x-slot name="heading">
                            {{ $action->getModalHeading() }}
                        </x-slot>

                        @if ($subheading = $action->getModalSubheading())
                            <x-slot name="subheading">
                                {{ $subheading }}
                            </x-slot>
                        @endif
                    @else
                        <x-slot name="header">
                            <x-filament::modal.heading>
                                {{ $action->getModalHeading() }}
                            </x-filament::modal.heading>

                            @if ($subheading = $action->getModalSubheading())
                                <x-filament::modal.subheading>
                                    {{ $subheading }}
                                </x-filament::modal.subheading>
                            @endif
                        </x-slot>
                    @endif

                    {{ $action->getModalContent() }}

                    @if ($action->hasFormSchema())
                        {{ $this->getMountedActionForm() }}
                    @endif

                    @if (count($action->getModalActions()))
                        <x-slot name="footer">
                            <x-filament::modal.actions :full-width="$action->isModalCentered()">
                                @foreach ($action->getModalActions() as $modalAction)
                                    {{ $modalAction }}
                                @endforeach
                            </x-filament::modal.actions>
                        </x-slot>
                    @endif
                @endif
            </x-filament::modal>
        </form>
    @endif
</div>
