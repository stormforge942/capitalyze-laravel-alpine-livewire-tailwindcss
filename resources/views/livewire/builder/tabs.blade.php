<div wire:init="init">
    <div class="flex items-center gap-x-6 overflow-x-auto text-sm+ whitespace-nowrap pb-2" x-data="{
        tabs: @js($tabs) || [],
        tabsCount: null,
        init() {
            this.tabs = this.tabs.filter(tab => tab)
            this.updateTabsCount();
        },
        updateTabsCount() {
            const container = document.querySelector('#main-container').children[0];
            const width = container.clientWidth;
    
            const count = Math.min(5, Math.floor(width / 250) - 1);
    
            this.tabsCount = count <= 0 ? 0 : count;
    
            // place active tab just before the more tab
            if (this.tabsCount && this.tabs.slice(this.tabsCount, this.tabs.length).find(tab => tab.id === {{ $activeTab }})) {
                const activeTabIndex = this.tabs.findIndex(tab => tab.id === {{ $activeTab }});
                const tmp = this.tabs[this.tabsCount - 1];
                this.tabs[this.tabsCount - 1] = this.tabs[activeTabIndex];
                this.tabs.splice(activeTabIndex, 1);
                this.tabs.splice(this.tabsCount, 0, tmp);
            }
        },
        removeTab(tab) {
            if (confirm('Are you sure?')) {
                $wire.deleteTab(tab.id);
            }
        }
    }"
        @resize.window.throttle="updateTabsCount()" wire:key="{{ \Str::random(5) }}">
        <template x-for="(tab, idx) in tabs.slice(0, tabsCount)" :key="tab.id">
            <div class="flex items-center gap-2" x-data="{
                value: tab.name,
                edit: false,
                save() {
                    this.edit = false;
                    if (this.value.trim()) {
                        $wire.updateTab(tab.id, this.value)
                    } else {
                        this.value = tab.name
                    }
                }
            }">
                <div class="flex items-center"
                    :class="tab.id === {{ $activeTab }} ? 'text-blue ownership-active-bread-link' : ''">
                    <a href="#" class="overflow-hidden truncate text-ellipsis inline-block"
                        @click.prevent="$wire.changeTab(tab.id)" x-text="value" x-show="!edit"
                        :data-tooltip-content="value.length > 24 ? value : null" style="max-width: 11rem;"></a>
                </div>
                <input type="text" x-model="value" class="h-6 px-2 w-36 focus:ring-0 focus:outline-none"
                    @keyup.escape="edit = false; value = tab.name" @keyup.enter="save" x-on:blur="save" x-ref="input"
                    x-show="edit" x-cloak>
                <button @click="edit = true; $nextTick(() => $refs.input?.focus())">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.27614 10.595L11.0375 3.83354L10.0947 2.89072L3.33333 9.65217V10.595H4.27614ZM4.82843 11.9283H2V9.09984L9.62333 1.47651C9.88373 1.21616 10.3058 1.21616 10.5661 1.47651L12.4518 3.36213C12.7121 3.62248 12.7121 4.04459 12.4518 4.30494L4.82843 11.9283ZM2 13.2616H14V14.595H2V13.2616Z"
                            fill="#3561E7" />
                    </svg>
                </button>
                <button type="button" @click="removeTab(tab)">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8 13C5.23857 13 3 10.7614 3 8C3 5.23857 5.23857 3 8 3C10.7614 3 13 5.23857 13 8C13 10.7614 10.7614 13 8 13ZM8 12C10.2092 12 12 10.2092 12 8C12 5.79086 10.2092 4 8 4C5.79086 4 4 5.79086 4 8C4 10.2092 5.79086 12 8 12ZM8 7.2929L9.4142 5.87868L10.1213 6.58578L8.7071 8L10.1213 9.4142L9.4142 10.1213L8 8.7071L6.58578 10.1213L5.87868 9.4142L7.2929 8L5.87868 6.58578L6.58578 5.87868L8 7.2929Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
        </template>

        <template x-if="tabs.length > tabsCount">
            <x-dropdown placement="bottom-end" :shadow="true">
                <x-slot name="trigger">
                    <div class="flex items-center gap-2"
                        @click="(tabsCount === 0 && tabs.length === 1) ? $event.stopPropagation() : null">
                        <span class="hover:text-dark-light2" :class="tabsCount === 0 ? 'text-blue' : ''"
                            x-text="tabsCount ? 'More' : tabs[0].name"></span>
                        <span
                            class="shrink-0 flex items-center justify-center w-4 h-4 text-xs text-white rounded-full bg-blue"
                            x-text="tabs.length - (tabsCount || 1)" x-show="!(tabsCount === 0 && tabs.length === 1)"
                            x-cloak></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none" x-show="!(tabsCount === 0 && tabs.length === 1)" x-cloak>
                            <path
                                d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                fill="#464E49" />
                        </svg>
                    </div>
                </x-slot>

                <div class="w-56 p-4 space-y-6">
                    <template x-for="tab in tabs.slice((tabsCount || 1), tabs.length)" :key="tab.id" hidden>
                        <div class="flex items-center justify-between gap-2">
                            <a href="#" class="whitespace-nowrap overflow-hidden text-ellipsis"
                                :class="tab.active ? `text-blue` : `hover:text-dark-light2`" x-text="tab.name"
                                @click.prevent="$wire.changeTab(tab.id)">
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
            </x-dropdown>
        </template>

        <button class="flex items-center gap-2 hover:opacity-70 transition-all" wire:click="addTab">
            <span class="font-semibold">{{ $addBtnLabel }}</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.0026 14.6693C4.3207 14.6693 1.33594 11.6845 1.33594 8.0026C1.33594 4.3207 4.3207 1.33594 8.0026 1.33594C11.6845 1.33594 14.6693 4.3207 14.6693 8.0026C14.6693 11.6845 11.6845 14.6693 8.0026 14.6693ZM7.33594 7.33594H4.66927V8.66927H7.33594V11.3359H8.66927V8.66927H11.3359V7.33594H8.66927V4.66927H7.33594V7.33594Z"
                    fill="#121A0F" />
            </svg>
        </button>
    </div>
</div>
