<div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded">
    <div class="sm:flex sm:items-start flex-col">
        <div class="block mb-3">
            <h1 class="text-base font-semibold leading-10 text-gray-900">
                Etf Holdings - {{ Str::title($etf->registrant_name ?? '') }} -
                {{ Str::title($quarters[$quarter] ?? '') }}
            </h1>
        </div>

        <div class="block mb-3">
            <label for="quarter-select">Quarter to view:</label>
            <select wire:model="quarter"
                class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500">
                @foreach ($quarters as $value => $text)
                    <option value="{{ $value }}">{{ $text }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <livewire:etf.holdings-table :etf="$etf" :quarter="$quarter" />
</div>
