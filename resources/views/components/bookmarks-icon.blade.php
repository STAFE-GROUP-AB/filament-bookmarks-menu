@if(!$exclude_page)
<div class="flex justify-end">
        @if(!$isBookmarked)
            <div wire:click="addBookmark">
                @svg(config('filament-bookmarks-menu.add_bookmark_icon'), config('filament-bookmarks-menu.add_bookmark_class'))
            </div>
        @else
            <div wire:click="removeBookmark">
                @svg(config('filament-bookmarks-menu.remove_bookmark_icon'), config('filament-bookmarks-menu.remove_bookmark_class'))
            </div>
        @endif

</div>
@endif
