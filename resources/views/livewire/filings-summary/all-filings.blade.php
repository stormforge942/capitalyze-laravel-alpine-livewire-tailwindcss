<div class="flex flex-col" x-data="{ openFilingPop: false, activeTab:@entangle('selectedTab') }">
    <div class="cus-loader" wire:loading.block style="top:  24rem !important;">
        <div class="cus-loaderBar"></div>
    </div>
    <div class="hidden md:flex bg-[#F2F2F2] w-full border-b-2 border-[#E4E4E4] justify-between">
        <div 
            @click.prevent="activeTab = 'all-documents'; $wire.handleTabs('all-documents')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'all-documents' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] mx-3'}`"
        >
            <a href="#">All Documents </a>
        </div>
        <div 
            @click.prevent="activeTab = 'financials'; $wire.handleTabs('financials')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'financials' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] mx-3'}`"
        >
            <a href="#">Financials </a>
        </div>
        <div 
            @click.prevent="activeTab = 'news'; $wire.handleTabs('news')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'news' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] mx-3'}`"
        >
            <a href="#">News </a>
        </div>
        <div 
            @click.prevent="activeTab = 'registrations-and-prospectuses'; $wire.handleTabs('registrations-and-prospectuses')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'registrations-and-prospectuses' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] mx-3'}`"
        >
            <a href="#">Registrations and Prospectuses </a>
        </div>
        <div 
            @click.prevent="activeTab = 'proxy-materials'; $wire.handleTabs('proxy-materials')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'proxy-materials' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] mx-3'}`"
        >
            <a href="#">Proxy Materials</a>
        </div>
        <div 
            @click.prevent="activeTab = 'ownership'; $wire.handleTabs('ownership')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'ownership' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] mx-3'}`"
        >
            <a href="#">Ownership</a>
        </div>
        <div 
            @click.prevent="activeTab = 'other'; $wire.handleTabs('other')" 
            :class="`mx-3 mt-1 -mb-0.5 font-[500] text-base ${ activeTab === 'other' ? 'border-b-[3px] border-[#13b05b] text-[#121A0F]':  'text-[#A5A5A5] '}`"
        >
            <a href="#">Others </a>
        </div>
    </div>
    <div class="md:hidden">
        <select wire:model="selectedTab" id="countries" wire:change="handleTabs($event?.target?.value)" class="change-select-chevron text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
            <option value="all-documents">All Documents</option>
            <option value="financials">Financials</option>
            <option value="news">News</option>
            <option value="registrations-and-prospectuses">Registrations and Prospectuses</option>
            <option value="proxy-materials">Proxy Materials</option>
            <option value="ownership">Ownership</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div>
        @if($selectedTab === 'all-documents')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @elseif($selectedTab === 'financials')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @elseif($selectedTab === 'other')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @elseif($selectedTab === 'news')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @elseif($selectedTab === 'registrations-and-prospectuses')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @elseif($selectedTab === 'proxy-materials')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @elseif($selectedTab === 'ownership')
            <livewire:is :component="'all-filings.'. $selectedTab" key="{{ now() }}" :company="$company"/>
        @endif
    </div>
    
    <!-- Dialog (full screen) -->
</div>
