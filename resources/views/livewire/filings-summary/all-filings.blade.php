<div class="flex flex-col relative" x-data="{ openFilingPop: false, activeTab: @entangle('selectedTab') }">
    <div class="hidden md:flex bg-[#F2F2F2] w-full gap-x-1 border-b border-[#D4DDD7]">
        <template
            x-for="(label, tab) in {
            'all-documents': 'All Documents',
            'financials': 'Financials',
            'news': 'News',
            'registrations-and-prospectuses': 'Registrations and Prospectuses',
            'proxy-materials': 'Proxy Materials',
            'ownership': 'Ownership',
            'other': 'Other'
        }"
            :key="tab">
            <a href="#" @click.prevent="activeTab = tab; $wire.handleTabs(tab); $wire.emit('emitCountInAllfilings', JSON.stringify([]));"
                class="py-2.5 px-6 text-center border-b-2 transition-all font-medium"
                :class="activeTab === tab ? 'border-green-dark' :
                    'border-transparent hover:border-gray-medium text-gray-medium2'"
                x-text="label">
            </a>
        </template>
    </div>
    <div class="md:hidden">
        <select wire:model="selectedTab" id="countries" wire:change="handleTabs($event?.target?.value)"
            class="change-select-chevron text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
            <option value="all-documents">All Documents</option>
            <option value="financials">Financials</option>
            <option value="news">News</option>
            <option value="registrations-and-prospectuses">Registrations and Prospectuses</option>
            <option value="proxy-materials">Proxy Materials</option>
            <option value="ownership">Ownership</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="relative">
        <div class="cus-loader" wire:loading.block>
            <div class="cus-loaderBar"></div>
        </div>

        <div class="flex flex-col">
            <livewire:all-filings.common-layout key="{{ now() }}" :selectedTab="$selectedTab" :company="$company" :checkedCount="$checkedCount" :selectChecked="$selectChecked" />
        </div>
    </div>

    <!-- Dialog (full screen) -->
</div>
