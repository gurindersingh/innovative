<div class="flex w-full max-w-sm">
    <form
        action="#"
        class="w-full"
        wire:submit="search"
    >
        <div class="relative flex w-full">
            <x-form.input
                type="text"
                class="w-full py-1"
                wire:model.live.debounce.350ms="search"
                name="search_part"
                placeholder="Search..."
            />
            <span class="absolute right-0 flex items-center justify-center h-full mr-2">
                <span
                    class="flex w-5 h-5 border border-r-0 border-blue-500 rounded-full animate-spin"
                    wire:loading
                    wire:target="search"
                ></span>
            </span>
        </div>
    </form>
</div>
