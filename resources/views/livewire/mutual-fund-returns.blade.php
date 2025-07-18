<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Fund Returns</h1>
                </div>
            </div>
            @if ($hasResults)
                <livewire:mutual-fund-returns-table :fund="$fund" :cik="$cik" :fund="$fund" :cik="$cik" :fund_symbol="$fund_symbol" :series_id="$series_id" :class_id="$class_id"/>
            @else
                <div class="text-gray-600">No results found.</div>
            @endif
        </div>
    </div>
</div>