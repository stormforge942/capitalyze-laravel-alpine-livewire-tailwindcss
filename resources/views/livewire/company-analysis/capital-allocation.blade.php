<div x-data="{
    activeSubTab: 'capital-structure',
    subtabs: {
        'capital-structure': 'Capital Structure',
        'source-n-uses': 'Sources and Uses',
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
        'capital-structure' => 'company-analysis.capital-allocation.capital-structure',
        'source-n-uses' => 'company-analysis.capital-allocation.source-and-uses',
    ] as $key => $value)
        <div class="subtab-container" x-show="activeSubTab == '{{ $key }}'" x-cloak>
            @livewire($value, ['company' => $company])
        </div>
    @endforeach
</div>
