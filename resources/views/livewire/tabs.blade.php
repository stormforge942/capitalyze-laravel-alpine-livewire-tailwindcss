<?php

$tabButtonId = 'tab-' . Str::random(8);
$dropdownId = 'tab-dropdown-' . Str::random(8);

?>

<div x-data="{
    active: $wire.active,
    changeTab(e) {
        const data = e.target.dataset;
        active = data.key;
        $wire.changeTab(data.key);
        $dispatch('tab-changed', JSON.parse(data.tab))
        e.target.scrollIntoView({ behavior: 'smooth', block: 'center' })
    }
}" x-init="$dispatch('tab-changed', $wire.tabs[active])" x-cloak>
    <div class="flex items-center lg:hidden">
        <div>
            <button id="{{ $tabButtonId }}" data-dropdown-toggle="{{ $dropdownId }}"
                class="min-w-[190px] bg-green-dark font-semibold rounded px-4 py-2.5 flex items-center justify-between gap-x-2"
                type="button">
                <span x-text="$wire.tabs[active].title"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M8.16703 10.6667L5.02055 7.52025C4.82528 7.32499 4.82528 7.00841 5.02054 6.81314L5.48011 6.35356C5.67537 6.15829 5.99196 6.15829 6.18722 6.35356L8.16703 8.33335L10.1468 6.35357C10.342 6.1583 10.6586 6.1583 10.8539 6.35357L11.3135 6.81314C11.5087 7.00841 11.5087 7.32499 11.3134 7.52024L8.16703 10.6667Z"
                        fill="#121A0F" />
                </svg>
            </button>

            <div id="{{ $dropdownId }}"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow min-w-[190px]">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="{{ $tabButtonId }}">
                    @foreach ($tabs as $key => $tab)
                        <li x-show="'{{ $key }}' !== active">
                            <button class="block w-full px-4 py-2 text-left" @click="changeTab"
                                data-tab='@json($tab)' data-key="{{ $key }}">
                                {{ $tab['title'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div>
            {{-- slot --}}
        </div>
    </div>

    <div class="hidden md:flex border border-[#D4DDD7] rounded bg-white w-full items-center gap-2 p-1 overflow-x-auto">
        @foreach ($tabs as $key => $tab)
            <button class="min-w-[250px] px-3 py-1.5 text-center rounded transition"
                :class="{
                    'bg-green-dark font-semibold': active ===
                        '{{ $key }}',
                    'font-medium text-gray-medium2 hover:bg-gray-light': active !==
                        '{{ $key }}'
                }"
                @click="changeTab" data-tab='@json($tab)' data-key="{{ $key }}">
                {{ $tab['title'] }}
            </button>
        @endforeach
    </div>

    <div class="mt-6">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>

        <div wire:loading.remove>
            @livewire($tabs[$active]['component'], ['data' => $data], key($active))
        </div>
    </div>
</div>
