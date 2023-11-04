<x-sidebar :links="$topNav">
    @if ($fund->cik)
        <hr class="my-4">
        <ul class="space-y-2 font-medium">
            @foreach ($bottomNav as $navbar)
                <li>
                    <livewire:company-navbar-item wire:key="{{ $navbar->route_name }}"
                        href="{{ route($navbar->route_name, ['cik' => $fund->cik, 'fund_symbol' => $fund->fund_symbol, 'series_id' => $fund->series_id, 'class_id' => $fund->class_id]) }}"
                        name="{{ $navbar->name }}" :active="$currentRoute === $navbar->route_name" />
                </li>
            @endforeach
        </ul>
    @endif
</x-sidebar>
