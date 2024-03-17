<div>
    <div>
        <h1 class="text-xl font-bold">Events Tracker</h1>
        <p class="mt-2 text-dark-light2">Recent filings of all companies.</p>
    </div>

    <div class="mt-6" x-data="{
        data: @js($data),
        tabActive: '{{ $activeTab }}',
        activeSubTab: '{{ $activeSubTab }}',
        search: '',
        get subTabs() {
            return this.data[this.tabActive];
        },
        init() {
            this.$watch('activeSubTab', (value) => {
                this.search = '';
                window.updateQueryParam('subtab', value);
                this.changeTable();
            });
    
            this.$watch('search', (value) => {
                this.changeTable();
            });
        },
        changeTable() {
            window.Livewire
                .emit(
                    'updateEventFilingsTable',
                    this.data[this.tabActive].find(subtab => subtab.title === this.activeSubTab).match,
                    this.search
                );
        }
    }">
        <?php
        $tabs = array_keys($data);
        $tabs = array_combine($tabs, $tabs);
        ?>

        <x-primary-tabs :tabs="$tabs" :active="$activeTab" min-width="160px"
            @tab-changed="tabActive = $event.detail.key; activeSubTab = subTabs[0].title;">
            <div>
                <div class="overflow-x-auto flex border-b border-[#D4DDD7]">
                    <template x-for="subtab in subTabs" :key="subtab.title">
                        <a href="#" class="inline-block w-[12rem] py-2.5 px-4 text-center border-b-2"
                            :class="activeSubTab === subtab.title ? 'border-green-dark' : 'border-transparent'"
                            @click.prevent="activeSubTab = subtab.title">
                            <p class="font-medium"
                                :class="activeSubTab === subtab.title ? 'text-dark' : 'text-gray-medium2'"
                                x-text="subtab.title"></p>
                            <p class="mt-1 text-sm leading-4"
                                :class="activeSubTab === subtab.title ? 'text-dark-light2' : 'text-gray-medium2'"
                                x-text="subtab.description"></p>
                        </a>
                    </template>
                </div>

                <div class="mt-6 bg-white flex items-center p-4 gap-x-4 border border-[#D4DDD7] rounded">
                    <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                            fill="#828C85" />
                    </svg>

                    <input type="search" placeholder="Search"
                        class="placeholder:text-gray-medium2 border-none flex-1 focus:outline-none focus:ring-0 h-6 min-w-0"
                        x-model.debounce.500ms="search">
                </div>

                <div class="mt-4">
                    <livewire:event-filings.table :config="$tableConfiguration" />
                </div>
            </div>
        </x-primary-tabs>
    </div>
</div>
