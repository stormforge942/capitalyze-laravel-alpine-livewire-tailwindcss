<div
    x-data="{
        open: @entangle($attributes->wire('model'))
    }"
    x-show="open"
    class="fixed top-0 left-0 z-50 flex items-center justify-center h-full w-full inset-0  text-left bg-white rounded-lg overflow-hidden shadow-xl md:max-w-xl"
>
<button wire:click="close">close</button>

    {{$body}}
</div>