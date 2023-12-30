<div class="flex flex-col" x-data="{ openFilingPop: false, activeTab:'all-documents' }">
    <div class="cus-loader" wire:loading.block style="top:  24.30rem !important;">
        <div class="cus-loaderBar"></div>
    </div>
    <div class="hidden md:flex bg-[#F2F2F2] w-full border-b-2 border-[#E4E4E4] justify-between">
        <div 
            wire:click.prevent="handleTabs('all-documents')" 
            @click="activeTab = 'all-documents'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'all-documents' }"
            class="mx-3 mt-1 -mb-0.5 text-[#121A0F] font-[500] text-base {{$selectedTab === 'all-documents' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">All Documents </a>
        </div>
        <div 
            wire:click.prevent="handleTabs('financials')" 
            @click="activeTab = 'financials'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'financials' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'financials' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Financials </a>
        </div>
        <div 
            wire:click.prevent="handleTabs('news')" 
            @click="activeTab = 'news'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'news' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'news' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">News </a>
        </div>
        <div 
            wire:click.prevent="handleTabs('registrations-and-prospectuses')" 
            @click="activeTab = 'registrations-and-prospectuses'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'registrations-and-prospectuses' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'registrations-and-prospectuses' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Registrations and Prospectuses </a>
        </div>
        <div 
            wire:click.prevent="handleTabs('proxy-materials')" 
            @click="activeTab = 'proxy-materials'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'proxy-materials' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'proxy-materials' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Proxy Materials</a>
        </div>
        <div 
            wire:click.prevent="handleTabs('ownership')" 
            @click="activeTab = 'ownership'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'ownership' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'ownership' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Ownership</a>
        </div>
        <div 
            wire:click.prevent="handleTabs('other')" 
            @click="activeTab = 'other'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'other' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'other' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Others </a>
        </div>
    </div>
    <div class="md:hidden">
        <select id="countries" wire:change="handleTabs($event?.target?.value)" class="change-select-chevron text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
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
