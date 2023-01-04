<div class="flex justify-end">
    @if ($menuitems)
        <x-filament::dropdown placement="bottom-end">
            <x-slot name="trigger" class="ml-4">
                <button  @class([
                'flex flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 items-center justify-center',
                'dark:bg-gray-900' => config('filament.dark_mode'),
            ]) aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
                    @svg(config('filament-bookmarks-menu.bookmark_icon'), config('filament-bookmarks-menu.bookmark_class'))
                </button>
            </x-slot>
            @if(!$menuitems->count())
                <p class="p-4">{{ __('filament-bookmarks-menu::filament-bookmarks-menu.notification.empty') }}</p>
            @endif
            <x-filament::dropdown.list>
                @if($menuitems->whereNull('menu_user_id')->count()>0)
                    @if(config('filament-bookmarks-menu.show_global_label_in_menu'))
                        <x-filament::dropdown.header
                            color="secondary"
                            tag="div"
                        >{{ __('filament-bookmarks-menu::filament-bookmarks-menu.label.global') }}
                        </x-filament::dropdown.header>
                    @endif
                    @foreach($menuitems->whereNull('menu_user_id') as $menuitem)
                        <x-filament::dropdown.item
                            :color="'secondary'"
                            icon=""
                            :href="$menuitem['menu_url']"
                            :target="$menuitem['menu_target']"
                            :tag="$menuitem['menu_url'] ? 'a' : 'button'"
                        >
                            {{ $menuitem['menu_label'] }}
                        </x-filament::dropdown.item>
                    @endforeach
                @endif
                @if($menuitems->whereNotNull('menu_user_id')->count()>0)
                        @if(config('filament-bookmarks-menu.show_private_label_in_menu'))
                            <x-filament::dropdown.header
                                color="secondary"
                                tag="div"
                            >{{ __('filament-bookmarks-menu::filament-bookmarks-menu.label.private') }}
                            </x-filament::dropdown.header>
                        @endif
                    @foreach($menuitems->whereNotNull('menu_user_id') as $menuitem)
                        <x-filament::dropdown.item
                            :color="'secondary'"
                            icon=""
                            :href="$menuitem['menu_url']"
                            :target="$menuitem['menu_target']"
                            action="Create"
                            :tag="$menuitem['menu_url'] ? 'a' : 'button'"
                        >
                          <div class="flex justify-between">
                              <span class="ml-2">
                              {{ $menuitem['menu_label'] }}
                              </span>
                              @if($menuItemToRemove)
                                  <span wire:click.prevent="deleteMenuItem('{{ $menuitem['id'] }}')" class="ml-2 {{config('filament-bookmarks-menu.delete_text_class')}}">
                                    {{ __('filament-bookmarks-menu::filament-bookmarks-menu.delete.confirm') }}
                                  </span>
                              @else
                                  <span wire:click.prevent="removeMenuItem('{{ $menuitem['id'] }}')" class="ml-2">
                                    @svg(config('filament-bookmarks-menu.delete_icon'), config('filament-bookmarks-menu.delete_class'))
                                  </span>
                              @endif
                          </div>
                        </x-filament::dropdown.item>
                    @endforeach
                @endif
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    @endif
</div>
