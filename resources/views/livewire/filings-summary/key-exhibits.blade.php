<div class="flex flex-col" x-data="{
    openExhibitsPop: false,
    activeTab: $wire.entangle('selectedTab'),
}">
    <div class="hidden md:flex bg-[#F2F2F2] w-full gap-x-1 border-b border-[#D4DDD7]">
        <template
            x-for="(label, tab) in {
        'articles-inc-bylaws': 'Articles of Inc. and Bylaws',
        'credit-agreement': 'Credit Agreement',
        'indentures': 'Indentures',
        'material-contracts': 'Material Contracts',
        'plans-reorganization': 'Plans of Reorganization',
        'underwriting-agreements': 'Underwriting Agreements'
    }"
            :key="tab">
            <a href="#" @click.prevent="activeTab = tab; $wire.emit('resetExhibitsFilters');"
                class="py-2.5 px-6 text-center border-b-2 transition-all font-medium"
                :class="activeTab === tab ? 'border-green-dark' :
                    'border-transparent hover:border-gray-medium text-gray-medium2'"
                x-text="label">
            </a>
        </template>
    </div>
    <div class="md:hidden">
        <select id="countries" wire:change="handleSelectTab($event?.target?.value)"
            class="change-select-chevron  text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
            <option value="articles-inc-bylaws">Articles of Inc. and Bylaws</option>
            <option value="credit-agreement">Credit Agreement</option>
            <option value="indentures">Indentures</option>
            <option value="material-contracts">Material Contracts</option>
            <option value="plans-reorganization">Plans of Reorganization</option>
            <option value="underwriting-agreements">Underwriting Agreements</option>
        </select>
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
