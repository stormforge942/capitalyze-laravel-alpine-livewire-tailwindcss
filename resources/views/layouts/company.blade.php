<x-guest-layout>
    <livewire:company-navbar :company="$attributes['company']" />
    {{ $slot }}
</x-guest-layout>
