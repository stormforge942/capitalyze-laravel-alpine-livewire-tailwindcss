<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Mutual Fund Holdings - {{ Str::title($fund->registrant_name) }} - {{ Str::title($quarters[$selectedQuarter]) }}</h1>
                </div>
                <div class="block mb-3">
                    <label for="quarter-select">Quarter to view:</label>
                    <select wire:model="selectedQuarter" id="quarter-select" class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500">
                        @foreach ($quarters as $quarterEndDate => $quarterText)
                            <option value="{{ $quarterEndDate }}">{{ $quarterText }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <livewire:mutual-fund-holdings-table :cik="$cik" :fund_symbol=$fund_symbol :series_id=$series_id :class_id=$class_id :selectedQuarter="$selectedQuarter"/>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', () => {
                updateUrl();
            });

            function updateUrl() {
                const selectedQuarter = document.getElementById('quarter-select').value;
                const url = new URL(window.location.href);
                url.searchParams.set('Quarter-to-view', selectedQuarter);
                window.history.pushState({}, '', url);
            }

            window.livewire.on('updateUrl', (data) => {
                updateUrl();
            });
        });
    </script>
@endpush