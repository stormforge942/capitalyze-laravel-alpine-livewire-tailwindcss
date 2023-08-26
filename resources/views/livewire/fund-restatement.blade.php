<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Fund restatement log</h1>
                </div>
            </div>
            @if ($hasResults)
                <livewire:fund-restatement-table :fund="$fund" :cik="$cik"/>
            @else
                <div class="text-gray-600">No results found.</div>
            @endif
        </div>
    </div>
</div>
