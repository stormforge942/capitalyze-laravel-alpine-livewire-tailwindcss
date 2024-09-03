<div class="flex flex-col h-full p-5 bg-gray-100">
    <div class="w-full mb-5 flex gap-5 items-start justify-between">
        <div class="font-medium uppercase">{{ $ticker }} (<small>{{ $company_name }}</small>)</div>

        <button wire:click="$emit('modal.close')">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                    fill="#C22929" />
            </svg>
        </button>
    </div>

    <div class="py-3" x-data="{
        activeTab: 'Summary',
    }">
        <div class="overflow-x-auto flex rounded-sm">
            <div class="flex rounded-md border-2 border-gray-100" style="padding: 0px;">
                @foreach ($tabs as $tab)
                    <a href="#" class="inline-block py-2 px-10 text-center border-2 transition-all"
                        :class="activeTab === '{{ $tab['title'] }}' ? 'bg-green-light border-green text-dark' :
                            'bg-transparent border-transparent text-gray-medium2 hover:bg-white hover:text-dark hover:border-green-light'"
                        @click.prevent="activeTab = '{{ $tab['title'] }}'">
                        <div class="font-medium flex flex-row items-center gap-x-3"
                            :class="activeTab === '{{ $tab['title'] }}' ? 'text-dark font-extrabold' : 'text-gray-medium2'">
                            @if ($tab['title'] != 'Summary')
                                <svg width="22px" height="22px">
                                    <circle cx="11" cy="11" r="11" fill="{{ $tab['icon'] }}" />
                                </svg>
                            @endif
                            <p>{{ $tab['title'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div x-show="activeTab == 'Summary'">
            <div class="py-3">
                <div class="mb-3"><livewire:investor-fund.fund-overview-graph :ticker="$ticker" /></div>
                <div><livewire:investor-fund.purchase-continuum-graph :data="$data" :price="$price" /></div>
            </div>
        </div>

        <template x-if="activeTab == 'New Buys'">
            <div class="pt-3">
                @foreach ($newbuys as $fund)
                    <div class="mb-3"><livewire:investor-fund.fund-item :fund="$fund" /></div>
                @endforeach
            </div>
        </template>

        <template x-if="activeTab == 'Increased'">
            <div class="pt-3">
                @foreach ($increased as $fund)
                    <div class="mb-3"><livewire:investor-fund.fund-item :fund="$fund" /></div>
                @endforeach
            </div>
        </template>

        <template x-if="activeTab == 'Reduced'">
            <div class="pt-3">
                @foreach ($reduced as $fund)
                    <div class="mb-3"><livewire:investor-fund.fund-item :fund="$fund" /></div>
                @endforeach
            </div>
        </template>
    </div>
</div>
