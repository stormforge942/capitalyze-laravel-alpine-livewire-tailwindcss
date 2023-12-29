<div class="flex flex-col" x-data="{
    activeTab: 'articles-inc-bylaws'
}">
    <div class="cus-loader" wire:loading.block style="top:  24rem !important;">
        <div class="cus-loaderBar"></div>
    </div>
    <div class="hidden md:flex bg-[#F2F2F2] w-full border-b-2 border-[#E4E4E4] justify-between">
        <div 
            wire:click.prevent="handleSelectTab('articles-inc-bylaws')" 
            @click="activeTab = 'articles-inc-bylaws'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'articles-inc-bylaws' }"
            class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'articles-inc-bylaws' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Articles of Inc. and Bylaws</a>
        </div>
        <div 
            wire:click.prevent="handleSelectTab('credit-agreement')"
            @click="activeTab = 'credit-agreement'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'credit-agreement' }" 
            class="mx-3 mt-1 -mb-0.5  font-[500] text-base {{$selectedTab === 'credit-agreement' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Credit Agreement </a>
        </div>
        <div 
            wire:click.prevent="handleSelectTab('indentures')" 
            @click="activeTab = 'indentures'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'indentures' }" 
            class="mx-3 mt-1 -mb-0.5  font-[500] text-base {{$selectedTab === 'indentures' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Indentures </a>
        </div>
        <div 
            wire:click.prevent="handleSelectTab('material-contracts')" 
            @click="activeTab = 'material-contracts'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'material-contracts' }" 
            class="mx-3 mt-1 -mb-0.5  font-[500] text-base {{$selectedTab === 'material-contracts' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Material Contracts </a>
        </div>
        <div 
            wire:click.prevent="handleSelectTab('plans-reorganization')"
            @click="activeTab = 'plans-reorganization'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'plans-reorganization' }"  
            class="mx-3 mt-1 -mb-0.5  font-[500] text-base {{$selectedTab === 'plans-reorganization' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Plans of Reorganization</a>
        </div>
        <div 
            wire:click.prevent="handleSelectTab('underwriting-agreements')" 
            @click="activeTab = 'underwriting-agreements'" :class="{ 'innertab-active text-[#121A0F]': activeTab === 'underwriting-agreements' }"  
            class="mx-3 mt-1 -mb-0.5  font-[500] text-base {{$selectedTab === 'underwriting-agreements' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"
        >
            <a href="#">Underwriting Agreements</a>
        </div>
    </div>
    <div class="md:hidden">
        <select id="countries" wire:change="handleSelectTab($event?.target?.value)" class="change-select-chevron  text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
            <option value="articles-inc-bylaws">Articles of Inc. and Bylaws</option>
            <option value="credit-agreement">Credit Agreement</option>
            <option value="indentures">Indentures</option>
            <option value="material-contracts">Material Contracts</option>
            <option value="plans-reorganization">Plans of Reorganization</option>
            <option value="underwriting-agreements">Underwriting Agreements</option>
        </select>
    </div>
    <!-- just for responsive view  -->
    <div class="mr-2 md:hidden absolute top-[52%] right-[2%] bg-white p-2 rounded-full">
        <div class="flex justify-between items-center">
            <div><img src="{{asset('/svg/filter-list.svg')}}"/></div>
            <h4 class="text-sm ml-2 text-[#121A0F] font-[400]">Table Optios</h4>
        </div>
    </div>
    <div>
        @if($selectedTab === 'articles-inc-bylaws')
            <livewire:is :component="'key-exhibits.'. $selectedTab" :company="$company"/>
        @elseif($selectedTab === 'credit-agreement')
            <livewire:is :component="'key-exhibits.'. $selectedTab" :company="$company"/>
        @elseif($selectedTab === 'indentures')
            <livewire:is :component="'key-exhibits.'. $selectedTab" :company="$company"/>
        @elseif($selectedTab === 'material-contracts')
            <livewire:is :component="'key-exhibits.'. $selectedTab" :company="$company"/>
        @elseif($selectedTab === 'plans-reorganization')
            <livewire:is :component="'key-exhibits.'. $selectedTab" :company="$company"/>
        @elseif($selectedTab === 'underwriting-agreements')
            <livewire:is :component="'key-exhibits.'. $selectedTab" :company="$company"/>
        @endif
    </div>
</div>
