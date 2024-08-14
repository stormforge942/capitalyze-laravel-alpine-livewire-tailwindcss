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
            switch (this.tabActive) {
                case 'Document Summaries':
                    window.Livewire.emit('updateDocumentSummariesTable', {}, this.search);
                    break;
                case 'Earning Presentations':
                    window.Livewire.emit('updateEarningPresentationsTable', {}, this.search);
                    break;
                default:
                    window.Livewire.emit('updateEventFilingsTable', this.data[this.tabActive].find(subtab => subtab.title === this.activeSubTab).match, this.search);
                    break;
            }
        }
    }">
        <?php
        $tabs = array_keys($data);
        $tabs = array_combine($tabs, $tabs);
        ?>

        <x-primary-tabs :tabs="$tabs" :active="$activeTab" min-width="160px"
            @tab-changed="tabActive = $event.detail.key; activeSubTab = subTabs[0]?.title;">
            <div>
                <template x-if="activeSubTab">
                    <div class="overflow-x-auto flex gap-x-1 border-b border-[#D4DDD7]">
                        <template x-for="subtab in subTabs" :key="subtab.title">
                            <a href="#"
                                class="inline-block w-[12rem] py-2.5 px-4 text-center border-b-2 transition-all"
                                :class="activeSubTab === subtab.title ? 'border-green-dark' :
                                    'border-transparent hover:border-gray-medium'"
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
                </template>

                <div class="mt-6">
                    <x-search-filter x-model.debounce.500ms="search" font-size="base"
                        placeholder="Search"></x-search-filter>
                </div>

                <div class="mt-4">
                    <div x-show="tabActive !== 'Document Summaries' && tabActive !== 'Earning Presentations'">
                        <livewire:event-filings.table :config="$tableConfiguration" />
                    </div>
                </div>
                <div x-show="tabActive === 'Document Summaries'">
                    <livewire:event-filings.document-summaries-table />
                </div>
            </div>
            <div x-show="tabActive === 'Earning Presentations'">
                <livewire:event-filings.earning-presentations-table />
            </div>
    </div>
</div>
</x-primary-tabs>
</div>
</div>
