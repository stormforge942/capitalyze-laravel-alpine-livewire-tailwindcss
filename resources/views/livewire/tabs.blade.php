<div x-data="{
    active: $wire.active,
    dropdown: null,
    changeTab(e, scroll = true) {
        const tab = JSON.parse(e.target.dataset.tab);
        this.active = tab.key;
        $wire.changeTab(tab.key);
        $dispatch('tab-changed', tab)

        if (scroll) {
            e.target.scrollIntoView({ behavior: 'smooth', block: 'center' })
        }
    },
    get activeTab() {
        return $wire.tabs[this.active];
    }
}" x-init="$dispatch('tab-changed', activeTab);
dropdown = new Dropdown($refs.dropdown, $refs.dropdownBtn)" x-cloak>
    <div class="flex flex-wrap items-center justify-between gap-2 lg:hidden">
        <div>
            <button x-ref="dropdownBtn"
                class="sm:min-w-[190px] bg-green-dark font-semibold rounded px-4 py-2.5 flex items-center justify-between gap-x-2"
                type="button">
                <span x-text="activeTab.title"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M8.16703 10.6667L5.02055 7.52025C4.82528 7.32499 4.82528 7.00841 5.02054 6.81314L5.48011 6.35356C5.67537 6.15829 5.99196 6.15829 6.18722 6.35356L8.16703 8.33335L10.1468 6.35357C10.342 6.1583 10.6586 6.1583 10.8539 6.35357L11.3135 6.81314C11.5087 7.00841 11.5087 7.32499 11.3134 7.52024L8.16703 10.6667Z"
                        fill="#121A0F" />
                </svg>
            </button>

            <div class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow min-w-[190px]" x-ref="dropdown">
                <div class="py-2 text-sm text-gray-700">
                    @foreach ($tabs as $key => $tab)
                        <button class="block w-full px-4 py-2 text-left"
                            @click="(e) => { 
                                changeTab(e, false); 
                                dropdown.hide()
                            }"
                            :data-tab='JSON.stringify($wire.tabs["{{ $key }}"])'
                            x-show="active !== '{{ $key }}'">
                            {{ $tab['title'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-slot"></div>
    </div>

    <div class="hidden lg:flex border border-[#D4DDD7] rounded bg-white w-full items-center gap-2 p-1 overflow-x-auto">
        @foreach ($tabs as $key => $tab)
            <button class="min-w-[250px] px-3 py-1.5 text-center rounded transition"
                :class="{
                    'bg-green-dark font-semibold': active ===
                        '{{ $key }}',
                    'font-medium text-gray-medium2 hover:bg-gray-light': active !==
                        '{{ $key }}'
                }"
                @click="changeTab" :data-tab='JSON.stringify($wire.tabs["{{ $key }}"])'>
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
