<?php $canSwitchPeriod = Str::endsWith($currentRoute, ['.metrics']) && ($hasQuarterly ?? true); ?>

<x-sidebar :links="$topNav">
    @if ($canSwitchPeriod || count($bottomNav))
        <hr class="my-4">

        <ul class="space-y-2 font-medium">
            @if ($canSwitchPeriod)
                <li>
                    <div class="relative ml-3">
                        <button wire:key="navbar-period-annual"
                            class="@if ($period == 'annual') text-blue-700 @else text-slate-700 pl-0 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500 pl-0"
                            wire:click="changePeriod('annual')">Annual</button>

                        <span class="text-indigo-600">|</span>

                        <button wire:key="navbar-period-quarterly"
                            class="@if ($period == 'quarterly') text-blue-700 @else text-slate-700 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500"
                            wire:click="changePeriod('quarterly')">Quarterly</button>
                    </div>
                </li>
            @endif

            @foreach ($bottomNav as $item)
                <li>
                    <livewire:company-navbar-item wire:key="{{ $item->route_name }}"
                        href="{{ route($item->route_name, ['ticker' => $model->symbol]) }}" name="{{ $item->name }}"
                        :active="$currentRoute === $item->route_name" />
                </li>
            @endforeach
        </ul>
    @endif
</x-sidebar>
