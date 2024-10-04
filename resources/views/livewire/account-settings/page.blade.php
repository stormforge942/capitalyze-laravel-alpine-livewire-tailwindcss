<div class="account-settings-page" x-data="{
    tabs: @js($tabs),
    tab: $wire.entangle('tab', true),
    subTab: $wire.entangle('subTab', true),
    init() {
        this.$watch('tab', (value) => window.updateQueryParam('tab', this.tab));
        this.$watch('subTab', (value) => window.updateQueryParam('subTab', this.subTab));
    },
    changeTab(tab) {
        this.tab = tab;
        this.subTab = this.subTabs[0].title
    },
    get subTabs() {
        return this.tabs[this.tab];
    },
    get subTabDescription() {
        return this.tabs[this.tab].find(i => i.title == this.subTab)?.description
    }
}">
    <h1 class="font-bold text-lg md:text-xl">Account Settings </h1>

    @if (count($tabs) > 1)
        <div class="flex items-center mt-8 gap-x-6 overflow-x-auto text-sm+ whitespace-nowrap pb-2" x-cloak>
            @foreach ($tabs as $tab => $_)
                <div class="flex items-center gap-2">
                    <div class="flex items-center"
                        :class="tab === '{{ $tab }}' ? 'text-blue ownership-active-bread-link' : ''">
                        <a href="#" class="overflow-hidden truncate text-ellipsis inline-block"
                            @click.prevent="changeTab('{{ $tab }}')" style="max-width: 11rem;">
                            {{ ucfirst($tab) }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-6 bg-white p-5 shadow w-full rounded-xl" x-data="{
        dropdown: null,
        init() {
            this.$nextTick(() => {
                this.dropdown = new Dropdown(this.$refs.dropdown, this.$refs.dropdownBtn, { placement: 'bottom-start' });
            });
        },
    }">
        <div class="mb-3 block lg:hidden" x-cloak>
            <button x-ref="dropdownBtn"
                class="sm:min-w-[190px] bg-green-dark font-semibold rounded px-4 py-2.5 flex items-center justify-between gap-x-2"
                type="button">
                <div class="flex items-center gap-x-2" x-text="subTabDescription"></div>

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                    fill="none">
                    <path
                        d="M8.16703 10.6667L5.02055 7.52025C4.82528 7.32499 4.82528 7.00841 5.02054 6.81314L5.48011 6.35356C5.67537 6.15829 5.99196 6.15829 6.18722 6.35356L8.16703 8.33335L10.1468 6.35357C10.342 6.1583 10.6586 6.1583 10.8539 6.35357L11.3135 6.81314C11.5087 7.00841 11.5087 7.32499 11.3134 7.52024L8.16703 10.6667Z"
                        fill="#121A0F" />
                </svg>
            </button>

            <div class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow min-w-[12rem]" x-ref="dropdown">
                <div class="py-2 text-sm text-gray-700">
                    <template x-for="tab in subTabs" :key="tab.title">
                        <button class="flex w-full px-4 py-2 text-left items-center gap-x-2"
                            @click="subTab = tab.title; dropdown.hide()" x-show="subTab !== tab.title">
                            <span x-text="tab.description"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="hidden lg:flex flex-col w-[35%] bg-white w gap-2 overflow-x-auto text-base mr-7" x-cloak>
                <template x-for="tab in subTabs" :key="tab.title">
                    <button class="px-4 py-3 rounded transition flex gap-2 box-content mb-6"
                        :class="{
                            'bg-green-light font-semibold border border-transparent': subTab === tab.title,
                            'font-medium text-gray-medium2 border hover:bg-gray-light': subTab !== tab.title
                        }"
                        @click="subTab = tab.title;">
                        <span class="whitespace-nowrap" x-text="tab.description"></span>
                    </button>
                </template>
            </div>

            <div class="lg:pl-7 lg:border-l w-full">
                @foreach (array_merge($tabs['admin'] ?? [], $tabs['mine']) as $tab)
                    <div x-show="subTab === '{{ $tab['title'] }}'" x-cloak>
                        @livewire($tab['component'], $tab['component'])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
