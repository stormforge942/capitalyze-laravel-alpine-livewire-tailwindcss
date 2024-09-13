<div class="flex flex-col h-full p-5 bg-gray-100">
    <div class="w-full mb-5 flex gap-5 items-start justify-between">
        <div class="font-medium uppercase">{{ $ticker }} (<small>{{ $company_name }}</small>)</div>

        <button wire:click="$emit('modal.close')" class="flex flex-row gap-x-1 items-center text-red font-semibold">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.99479 14.6663C4.31289 14.6663 1.32812 11.6815 1.32812 7.99967C1.32812 4.31777 4.31289 1.33301 7.99479 1.33301C11.6767 1.33301 14.6615 4.31777 14.6615 7.99967C14.6615 11.6815 11.6767 14.6663 7.99479 14.6663ZM7.99479 7.05687L6.10917 5.17125L5.16636 6.11405L7.05199 7.99967L5.16636 9.88527L6.10917 10.8281L7.99479 8.94247L9.88039 10.8281L10.8232 9.88527L8.93759 7.99967L10.8232 6.11405L9.88039 5.17125L7.99479 7.05687Z" fill="#C22929"/>
            </svg>

            Close
        </button>
    </div>

    <div class="py-3" x-data="{
        activeTab: 'Summary',
    }">
        <div class="overflow-x-auto flex rounded-sm">
            <div class="flex rounded-md border-2 border-[#D4DDD7]" style="padding: 0px;">
                @foreach ($tabs as $tab)
                    <a href="#" class="inline-block py-2 px-10 text-center border-2 transition-all rounded-md"
                        :class="activeTab === '{{ $tab['title'] }}' ? 'bg-green-light border-green text-dark font-bold' :
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
