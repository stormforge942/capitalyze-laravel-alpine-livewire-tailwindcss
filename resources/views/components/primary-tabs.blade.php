<div x-data="{
    active: '{{ $active }}',
    dropdown: null,
    tabs: @js($tabs),
    showActive: false,
    changeTab(key) {
        if (this.active === key) return;

        const tab = this.tabs[key];
        this.active = tab.key;

        this.setQueryString(tab.key);

        this.$dispatch('tab-changed', tab)
    },
    get activeTab() {
        return this.tabs[this.active];
    },
    init() {
        this.dropdown = new Dropdown(this.$refs.dropdown, this.$refs.dropdownBtn, { placement: 'bottom-start' });
        this.setQueryString(this.active);

        @if ($triggerChange) this.$nextTick(() => this.$dispatch('tab-changed', this.activeTab)) @endif

        this.$nextTick(() => {
            this.showActive = true;
        })
    },
    setQueryString(tab) {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url);
    },
}" {{ $attributes }}>
    <div class="flex flex-wrap items-center justify-between gap-2 lg:hidden text-base">
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

            <div class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow min-w-[12rem]" x-ref="dropdown">
                <div class="py-2 text-sm text-gray-700">
                    <template x-for="(tab, key) in tabs" :key="key">
                        <button class="block w-full px-4 py-2 text-left"
                            @click="(e) => { 
                                changeTab(key, false); 
                                dropdown.hide()
                            }"
                            x-show="active !== key" x-text="tab.title">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div class="tab-slot block lg:hidden" x-ref="slot">
            {{ $head ?? '' }}
        </div>
    </div>

    <div
        class="hidden lg:flex border border-[#D4DDD7] rounded bg-white w-full items-center gap-2 p-1 overflow-x-auto text-base" wire:ignore>
        <template x-for="(tab, key) in tabs" :key="key">
            <button class="px-3 py-1.5 text-center rounded transition"
                :class="{
                    'bg-green-dark font-semibold': active === key && showActive,
                    'font-medium text-gray-medium2 hover:bg-gray-light': active !== key
                }"
                @click="changeTab(key)" style="min-width: {{ $minWidth }}" x-text="tab.title">
            </button>
        </template>
    </div>

    <div class="mt-4 lg:mt-6">
        {{ $slot ?? '' }}
    </div>
</div>
