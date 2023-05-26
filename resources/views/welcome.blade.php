<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-full max-w-7xl">
            <div class="px-24 py-8 overflow-hidden bg-white shadow-xl sm:rounded-lg ">
            <object data="{{ URL::to('/') }}/svg/xbrl-process.svg" type="image/svg+xml" alt="xbrl process"></object>
            </div>
        </div>
    </div>

</x-guest-layout>
