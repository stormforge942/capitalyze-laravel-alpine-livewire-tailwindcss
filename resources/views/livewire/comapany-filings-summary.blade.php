<div class="flex flex-col" x-data="{
    activeTab: '{{ $tabName }}'
}">
    <div class="flex flex-col mx-0 sm:mx-6 md:lg-0 ml-0">
        <x-company-info-header :company="['name' => $company->name, 'ticker' => $company->ticker]">
            <x-download-data-buttons />
        </x-company-info-header>

        <div>
            <div class="hidden lg:flex tabs-wrapper w-full">
                <div @class([
                    'tab text-base font-[500]',
                    'active font-[600]' => $tabName == 'summary',
                ]) wire:click="setTabName('summary')" @click="activeTab = 'summary'"
                    :class="{ 'active': activeTab === 'summary' }">Filings Summary</div>
                <div @class([
                    'tab text-base font-[500]',
                    'active font-[600]' => $tabName == 'all-filings',
                ]) wire:click="setTabName('all-filings')"
                    @click="activeTab = 'all-filings'" :class="{ 'active': activeTab === 'all-filings' }">All Filings
                </div>
                <div @class([
                    'tab text-base font-[500]',
                    'active font-[600]' => $tabName == 'key-exhibits',
                ]) wire:click="setTabName('key-exhibits')"
                    @click="activeTab = 'key-exhibits'" :class="{ 'active': activeTab === 'key-exhibits' }">Key Exhibits
                </div>
                <div @class([
                    'tab text-base font-[500]',
                    'active font-[600]' => $tabName == 'earning-presentations',
                ]) wire:click="setTabName('earning-presentations')"
                    @click="activeTab = 'earning-presentations'"
                    :class="{ 'active': activeTab === 'earning-presentations' }">Earning Presentations</div>
            </div>
            <div class="flex lg:hidden justify-between relative w-full mt-2 mx-0 mb-3" x-data="{ dropdownMenu: false }"
                @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
                <button @click="dropdownMenu = ! dropdownMenu"
                    class="flex items-center py-2 px-4 bg-[#52D3A2]  rounded">
                    <span
                        class="mr-4 text-sm p-x-4 font-[600]">{{ $tabName === 'summary' ? 'Filings Summary' : ($tabName === 'all-filings' ? 'All Filings' : 'Key Exhibits') }}
                    </span>
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="dropdownMenu" class="absolute z-50 left-0 py-2 mt-10 bg-white rounded-md shadow-xl w-44">
                    <div class="flex justify-start items-center content-start" @click="dropdownMenu = false"
                        wire:click.prevent="setTabName('summary')">
                        <a href="javascript;" class="block px-4 py-2 text-sm font-[600]">
                            Filings Summary
                        </a>
                        @if ($tabName == 'summary')
                            <div><img src="{{ asset('/svg/tick.svg') }}" alt="tick" /></div>
                        @endif
                    </div>
                    <div class="flex justify-start items-center content-start" @click="dropdownMenu = false"
                        wire:click.prevent="setTabName('all-filings')">
                        <a href="javascript;" class="block px-4 py-2 text-sm font-[600]">
                            All Filings
                        </a>
                        @if ($tabName == 'all-filings')
                            <div><img src="{{ asset('/svg/tick.svg') }}" alt="tick" /></div>
                        @endif
                    </div>
                    <div class="flex justify-start items-center content-start" @click="dropdownMenu = false"
                        wire:click.prevent="setTabName('key-exhibits')">
                        <a href="javascript;" class="block px-4 py-2 text-sm font-[600]">
                            Key Exhibits
                        </a>
                        @if ($tabName == 'key-exhibits')
                            <div><img src="{{ asset('/svg/tick.svg') }}" alt="tick" /></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($loading)
            <div wire:loading.block class="justify-center items-center w-full mt-2 mb-5">
                <x-loader />
            </div>
        @endif

        <div>
            @if ($tabName === 'summary')
                <livewire:is :component="'filings-summary.' . $tabName" :company="$company" :ticker="$ticker" />
            @elseif($tabName === 'all-filings')
                <livewire:is :component="'filings-summary.' . $tabName" :company="$company" :ticker="$ticker" />
            @elseif($tabName === 'key-exhibits')
                <livewire:is :component="'filings-summary.' . $tabName" :company="$company" :ticker="$ticker" />
            @elseif($tabName === 'earning-presentations')
                <livewire:filings-summary.earning-presentations :ticker="$company->ticker" />
            @endif
        </div>
    </div>
</div>
