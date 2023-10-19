<div>
    <label class="flex items-center gap-1 text-sm">
        <span>Quarter to view</span>
        <select class="border-[0.5px] border-solid border-[#93959880] p-2 rounded-full" wire:model="quarter">
            <option value="">Select a quarter</option>
            @foreach ($quarters as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
    </label>

    <livewire:ownership.shareholder-holdings-table :cik="$cik" :quarter="$quarter" />
</div>
