<x-sidebar :links="$topNav">
    <hr class="my-4">
    <ul class="space-y-2 font-medium">
        @foreach ($bottomNav as $navbar)
            <li>
                <livewire:company-navbar-item wire:key="{{ $navbar->route_name }}"
                    href="{{ route($navbar->route_name, ['cik' => $fund->cik, 'ticker' => $fund->cik]) }}"
                    name="{{ $navbar->name }}" :active="$currentRoute === $navbar->route_name" />
            </li>
        @endforeach
    </ul>
</x-sidebar>