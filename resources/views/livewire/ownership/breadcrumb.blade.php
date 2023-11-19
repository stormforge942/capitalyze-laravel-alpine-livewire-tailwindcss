<x-breadcrumb :items="[
    [
        'text' => 'Ownership',
    ],
    [
        'text' => 'Shareholders',
        'href' => route('company.ownership', ['ticker' => $ticker]),
    ],
]">
    <div class="ml-2 font-normal flex items-center gap-4 md:gap-6 text-[#7C8286] text-sm+" x-data="{
        tabs: @js($historyItems),
        tabsCount: 3,
        init() {
            this.updateTabsCount();
        },
        updateTabsCount() {
            const width = window.innerWidth;
    
            if (width >= 1536) {
                this.tabsCount = 3;
            } else if (width >= 768) {
                this.tabsCount = 2;
            } else if (width >= 640) {
                this.tabsCount = 1;
            } else {
                this.tabsCount = 0;
            }
        },
        removeTab(tab) {
            this.tabs = this.tabs.filter(t => t.url !== tab.url);
    
            $wire.removeTab(tab);
        }
    }"
        @resize.window.throttle="updateTabsCount()">
        <template x-for="tab in tabs.slice(0, tabsCount)" :key="tab.url">
            <div class="flex items-center gap-2">
                <a :href="tab.active ? '#' : tab.url" class="hover:text-dark-light2 whitespace-nowrap"
                    :class="tab.active ? `text-blue ownership-active-bread-link` : ''" x-text="tab.name"></a>

                <button class="h-4 w-4" @click="removeTab(tab)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"
                        fill="none">
                        <path
                            d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
        </template>

        <template x-if="tabs.length > tabsCount">
            <div x-data="{ dropdown: null }" x-init="dropdown = new Dropdown($refs.dropdown, $refs.button, { placement: 'bottom-end' })">
                <button class="flex items-center gap-2" x-ref="button">
                    <span class="hover:text-dark-light2" :class="tabsCount === 0 ? 'text-blue' : ''"
                        x-text="tabsCount ? 'More' : tabs[0].name"></span>
                    <span
                        class="shrink-0 flex items-center justify-center w-4 h-4 text-xs text-white rounded-full bg-blue"
                        x-text="tabs.length - (tabsCount || 1)"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#464E49" />
                    </svg>
                </button>

                <div class="hidden w-44 p-4 bg-white border border-[#D4DDD7] rounded space-y-6"
                    style="box-shadow: 4px 0px 8px 0px rgba(0, 0, 8, 0.08);" x-ref="dropdown">
                    <template x-for="tab in tabs.slice((tabsCount || 1), tabs.length)" :key="tab.url" hidden>
                        <div class="flex items-center justify-between gap-2">
                            <a :href="tab.active ? '#' : tab.url"
                                :class="tab.active ? `text-blue` : `hover:text-dark-light2`" x-text="tab.name">
                            </a>

                            <button @click="removeTab(tab)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                    viewBox="0 0 10 10" fill="none">
                                    <path
                                        d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                                        fill="#C22929" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <button class="hidden md:block whitespace-nowrap font-semibold lg:block text-red" wire:click="clearHistory"
            x-show="tabs.length" x-cloak>
            Clear All
        </button>
    </div>
</x-breadcrumb>
