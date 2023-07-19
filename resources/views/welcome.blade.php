<x-guest-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    @livewire('search-component')

    <div class="py-12">
        <div class="mx-auto max-w-full max-w-7xl">
            <div class="px-40 py-8 overflow-hidden bg-white sm:rounded-lg ">
            <object data="{{ asset('svg/xbrl-process.svg') }}" type="image/svg+xml" alt="xbrl process"></object>
            </div>
        </div>
    </div>



</x-guest-layout>