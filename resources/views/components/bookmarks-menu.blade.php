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
                <p class="pl-2 text-gray-600 text-sm border-b">Globala</p>
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

                <p class="pl-2 text-gray-600 text-sm border-b">Privata</p>
                @foreach($resources->whereNotNull('menu_user_id') as $resource)
                    <x-filament::dropdown.item
                        :color="'secondary'"
                        icon=""
                        :href="$resource['menu_url']"
                        :target="$resource['menu_target']"
                        action="Create"
                        :tag="$resource['menu_url'] ? 'a' : 'button'"
                    >
                       <div class="flex justify-between"><span>{{ $resource['menu_label'] }}</span><span wire:click.prevent="deleteBookmark({{ $resource->id }})">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-danger-600">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                           </span></div>
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
