<x-wire-elements-pro::tailwind.slide-over>
    <div wire:init="load">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div wire:loading.remove>
            {!! $content !!}
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
