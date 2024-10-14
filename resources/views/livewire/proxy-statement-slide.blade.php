<x-wire-elements-pro::tailwind.slide-over>
    @if ($loaded == false)
        <div class="grid place-content-center h-full" role="status" wire:init="loadData">
            <div class=" grid place-items-center">
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
            <span class="sr-only">Loading...</span>
        </div>
    @else
        {!! $data !!}
    @endif
</x-wire-elements-pro::tailwind.slide-over>
