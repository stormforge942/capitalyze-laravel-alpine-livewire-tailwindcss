<div x-data="{
    active: '{{ $active }}',
    dropdown: null,
    queryLabel: @js($queryLabel),
    tabs: @js($tabs),
    badges: @js($badges),
    showActive: false,
    changeTab(key) {
        if (this.active === key) return;

        const tab = this.tabs[key];
        this.active = tab.key;

        this.$dispatch('tab-changed', tab)
    },
    get activeTab() {
        return this.tabs[this.active];
    },
    init() {
        this.dropdown = new Dropdown(this.$refs.dropdown, this.$refs.dropdownBtn, { placement: 'bottom-start' });
        window.updateQueryParam(this.queryLabel, this.active);

        @if ($triggerChange) this.$nextTick(() => this.$dispatch('tab-changed', this.activeTab)) @endif

        {{-- to remove the glitch when using this component with x-modelable --}}
        this.$nextTick(() => {
            this.showActive = true;
        })

        this.$watch('active', (value) => {
            window.updateQueryParam(this.queryLabel, value);
        })
    },
}" {{ $attributes }}>
    <div class="flex flex-wrap items-center justify-between gap-2 lg:hidden text-base" x-cloak>
        <div>
            <button x-ref="dropdownBtn"
                class="sm:min-w-[190px] bg-green-dark font-semibold rounded px-4 py-2.5 flex items-center justify-between gap-x-2"
                type="button">
                <div class="flex items-center gap-x-2">
                    <span x-text="activeTab.title"></span>

                    <template x-if="badges.hasOwnProperty(activeTab.key) && badges[activeTab.key] !== null">
                        <span
                            class="text-white font-semibold px-1.5 py-1 text-xs rounded-full grid place-items-center bg-dark"
                            style="min-width: 1.5rem;" x-text="badges[activeTab.key]"></span>
                    </template>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                    fill="none">
                    <path
                        d="M8.16703 10.6667L5.02055 7.52025C4.82528 7.32499 4.82528 7.00841 5.02054 6.81314L5.48011 6.35356C5.67537 6.15829 5.99196 6.15829 6.18722 6.35356L8.16703 8.33335L10.1468 6.35357C10.342 6.1583 10.6586 6.1583 10.8539 6.35357L11.3135 6.81314C11.5087 7.00841 11.5087 7.32499 11.3134 7.52024L8.16703 10.6667Z"
                        fill="#121A0F" />
                </svg>
            </button>

            <div class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow min-w-[12rem]" x-ref="dropdown">
                <div class="py-2 text-sm text-gray-700">
                    <template x-for="(tab, key) in tabs" :key="key">
                        <button class="flex w-full px-4 py-2 text-left items-center gap-x-2"
                            @click="(e) => { 
                                changeTab(key, false); 
                                dropdown.hide()
                            }"
                            x-show="active !== key">

                            <span x-text="tab.title"></span>

                            <template x-if="badges.hasOwnProperty(key) && badges[key] !== null">
                                <span
                                    class="text-white font-semibold px-1.5 py-1 text-xs rounded-full grid place-items-center"
                                    style="min-width: 1.5rem;"
                                    :class="{
                                        'bg-dark': active === key && showActive,
                                        'bg-gray-medium2': active !== key || !showActive
                                    }"
                                    x-text="badges[key]"></span>
                            </template>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div class="tab-slot block lg:hidden" x-ref="slot">
            {{ $head ?? '' }}
        </div>
    </div>

    <div class="hidden lg:flex border border-[#D4DDD7] rounded-lg bg-white w-full items-center gap-2 p-1 overflow-x-auto text-base"
        wire:ignore x-cloak>
        <template x-for="(tab, key) in tabs" :key="key">
            <button class="px-2 py-1.5 text-center rounded transition flex justify-center items-center gap-2 box-content"
                :class="{
                    'bg-green-dark font-semibold': active === key && showActive,
                    'font-medium text-gray-medium2 hover:bg-gray-light': active !== key || !showActive
                }"
                @click="changeTab(key)" style="min-width: {{ $minWidth }}">
                <span class="whitespace-nowrap" x-text="tab.title"></span>

                <template x-if="badges.hasOwnProperty(key) && badges[key] !== null">
                    <span class="text-white font-semibold px-1.5 py-1 text-xs rounded-full grid place-items-center"
                        style="min-width: 1.5rem;"
                        :class="{
                            'bg-dark': active === key && showActive,
                            'bg-gray-medium2': active !== key || !showActive
                        }"
                        x-text="badges[key]"></span>
                </template>
            </button>
        </template>
    </div>

    <div class="mt-4 lg:mt-6">
        {{ $slot ?? '' }}
    </div>
</div>
