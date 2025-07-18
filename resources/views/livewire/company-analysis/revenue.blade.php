<div x-data="{
    activeSubTab: 'product',
    subtabs: {
        'product': 'Revenue By Product',
        'geography': 'Revenue By Geography',
        'employee': 'Revenue By Employee',
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
    <div class="overflow-x-auto flex border-b border-[#D4DDD7] mb-6 gap-x-1">
        <template x-for="(title, subtab) in subtabs" :key="subtab">
            <a href="#" class="inline-block w-[12rem] py-2.5 px-4 text-center border-b-2 transition-all"
                :class="activeSubTab === subtab ? 'border-green-dark' :
                    'border-transparent hover:border-gray-medium'"
                @click.prevent="activeSubTab = subtab">
                <p class="font-medium" :class="activeSubTab === subtab ? 'text-dark' : 'text-gray-medium2'"
                    x-text="title"></p>
            </a>
        </template>
    </div>

    @foreach ([
        'product' => 'company-analysis.revenue.product',
        'geography' => 'company-analysis.revenue.geography',
        'employee' => 'company-analysis.revenue.employee',
    ] as $key => $value)
        <div :class="{'invisible h-0 overflow-hidden': activeSubTab !== '{{ $key }}'}" class="subtab-container" x-cloak>
            @livewire($value, ['company' => $company])
        </div>
    @endforeach
</div>
