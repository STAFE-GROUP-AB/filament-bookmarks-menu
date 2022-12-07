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
                    <p class="pl-2 text-gray-600 dark:text-gray-200 border-b">{{ __('filament-bookmarks-menu::filament-bookmarks-menu.label.global') }}</p>
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
                    <p class="pl-2 text-gray-600 dark:text-gray-200 border-b">{{ __('filament-bookmarks-menu::filament-bookmarks-menu.label.private') }}</p>
                    @foreach($menuitems->whereNotNull('menu_user_id') as $menuitem)
                        <x-filament::dropdown.item
                            :color="'secondary'"
                            icon=""
                            :href="$menuitem['menu_url']"
                            :target="$menuitem['menu_target']"
                            action="Create"
                            :tag="$menuitem['menu_url'] ? 'a' : 'button'"
                        >
                          {{ $menuitem['menu_label'] }}
                        </x-filament::dropdown.item>
                    @endforeach
                @endif
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    @endif
</div>
