<div class="flex flex-col h-full p-5">
    <div class="mb-5 flex items-center justify-between">
        <div class="font-medium uppercase">Content</div>

        <button wire:click="$emit('modal.close')">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                    fill="#C22929" />
            </svg>
        </button>
    </div>
    @if (!$loaded)
        <div class="py-24 grid place-items-center" wire:init="loadData">
            <span class="mx-auto simple-loader text-green"></span>
        </div>
    @elseif($content)
        <div>
            {!! $content !!}
        </div>
    @else
        <p class="text-gray-500 text-center py-24">No result found</p>
    @endif
</div>
