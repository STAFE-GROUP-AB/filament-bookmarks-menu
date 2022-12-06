@if(!$exclude_page)
<div class="flex justify-end">

        @if(!$isBookmarked)
            <svg wire:click="addBookmark" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6 text-danger-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
        @else
            <svg wire:click="removeBookmark" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6 text-danger-700" viewBox="0 0 20 20" fill="currentColor">
                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
            </svg>
        @endif

</div>
@if(!$isBookmarked)
<div class="flex justify-end">
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <button type="submit">
            Save
        </button>
    </form>

</div>
@endif
@endif
