<div class="flex flex-col" x-data="{ open: false }">
    <!-- <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
        <span class="mx-auto simple-loader !text-blue"></span>
    </div> -->
    <div class="hidden md:flex bg-[#F2F2F2] w-full border-b-2 border-[#E4E4E4] justify-between">
        <div wire:click.prevent="handleTabs('all-documents')" class="mx-3 mt-1 -mb-0.5 text-[#121A0F] font-[500] text-base {{$selectedTab === 'all-documents' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">All Documents </a></div>
        <div wire:click.prevent="handleTabs('financials')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'financials' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Financials </a></div>
        <div wire:click.prevent="handleTabs('news')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'news' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">News </a></div>
        <div wire:click.prevent="handleTabs('registrations-and-prospectuses')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'registrations-and-prospectuses' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Registrations and Prospectuses </a></div>
        <div wire:click.prevent="handleTabs('proxy-materials')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'proxy-materials' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Proxy Materials</a></div>
        <div wire:click.prevent="handleTabs('ownership')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'ownership' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Ownership</a></div>
        <div wire:click.prevent="handleTabs('other')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'other' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Others </a></div>
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
    
    <!-- Dialog (full screen) -->
    <div class="fixed z-50 top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);" x-show="open"  >
        <livewire:all-filings.filings-pop-up/>
    </div>
</div>
