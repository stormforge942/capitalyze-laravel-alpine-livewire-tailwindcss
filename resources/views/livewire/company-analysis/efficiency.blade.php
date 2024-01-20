<div x-data="{
    activeSubTab: 'cost-structure',
    subtabs: {
        'cost-structure': 'Cost Structure',
        'fcf-conversion': 'FCF Conversion',
    },
    init() {
        if (Object.keys(this.subtabs).includes('{{ request('subtab') }}')) {
            this.activeSubTab = '{{ request('subtab') }}';
        }

        this.$watch('activeSubTab', value => {
            {{-- to fix input rangeslider --}}
            setTimeout(() => window.dispatchEvent(new Event('resize')), 100)

            window.updateQueryParam('subtab', value);
        });
    }
}">
    <div class="overflow-x-auto flex border-b border-[#D4DDD7] mb-6">
        <template x-for="(title, subtab) in subtabs" :key="subtab">
            <a href="#" class="inline-block w-[12rem] py-2.5 px-4 text-center border-b-2"
                :class="activeSubTab === subtab ? 'border-green-dark' :
                    'border-transparent'"
                @click.prevent="activeSubTab = subtab">
                <p class="font-medium" :class="activeSubTab === subtab ? 'text-dark' : 'text-gray-medium2'"
                    x-text="title"></p>
            </a>
        </template>
    </div>

    @foreach ([
        'cost-structure' => 'company-analysis.efficiency.cost-structure',
        'fcf-conversion' => 'company-analysis.efficiency.fcf-conversion',
    ] as $key => $value)
        <div x-show="activeSubTab == '{{ $key }}'" x-cloak>
            @livewire($value, ['company' => $company, 'statements' => $statements])
        </div>
    @endforeach
</div>
