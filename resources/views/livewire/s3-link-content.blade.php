<x-wire-elements-pro::tailwind.slide-over>
    <div class="h-full" wire:init="load">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="relative h-full" wire:loading.remove>
            <iframe class="w-full h-full" srcdoc="{!! strip_tags(htmlspecialchars($content)) !!}" frameborder="0"></iframe>
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
