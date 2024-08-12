<div class="flex flex-col relative" x-data="{
    openExhibitsPop: false,
    activeTab: @entangle('selectedTab'),
    tabs: {
        'articles-inc-bylaws': 'Articles of Inc. and Bylaws',
        'credit-agreement': 'Credit Agreement',
        'indentures': 'Indentures',
        'material-contracts': 'Material Contracts',
        'plans-reorganization': 'Plans of Reorganization',
        'underwriting-agreements': 'Underwriting Agreements'
    }
}">
    <div class="hidden md:flex bg-[#F2F2F2] w-full gap-x-1 border-b border-[#D4DDD7]">
        <template
            x-for="(label, tab) in tabs" :key="tab">
            <a href="#" @click.prevent="activeTab = tab; $wire.emit('resetExhibitsFilters');"
               class="py-2.5 px-6 text-center border-b-2 transition-all font-medium"
               :class="activeTab === tab ? 'border-green-dark' :
                    'border-transparent hover:border-gray-medium text-gray-medium2'"
               x-text="label">
            </a>
        </template>
    </div>

    <div class="md:hidden">
        <div class="flex lg:hidden justify-between relative w-full mt-1 mx-0" x-data="{ dropdownMenu: false }" @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
            <button @click="dropdownMenu = !dropdownMenu" class="flex items-center py-0 px-2">
                <span class="mr-4 text-[13px] p-x-4 font-[500]" x-text="tabs[activeTab]"></span>
                <img src="{{ asset('/svg/chevron-down-with-circle.svg') }}" alt="tick" />
            </button>
            <div x-show="dropdownMenu" class="absolute z-50 left-0 py-2 mt-10 bg-white rounded-md shadow-xl w-full">
                <template x-for="(label, tab) in tabs">
                    <div class="flex justify-start items-center content-start" @click="dropdownMenu = false; $wire.handleTabs(tab);">
                        <a href="#" class="block px-4 py-2 text-sm font-[600]" x-text="label"></a>

                        <template x-if="activeTab === tab"><img src="{{ asset('/svg/tick.svg') }}" alt="tick" /></template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="relative">
        <div wire:loading.block class="justify-center items-center w-full mt-5">
            <x-loader />
        </div>

        <div class="flex flex-col">
            <livewire:key-exhibits.common-layout key="{{ now() }}" :selectedTab="$selectedTab" :company="$company" :checkedCount="$checkedCount" :selectChecked="$selectChecked" />
        </div>
    </div>
</div>
