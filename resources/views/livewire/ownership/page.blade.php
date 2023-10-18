<div class="px-8" x-data="{ tab: null }" @tab-changed="tab = $event.detail;">
    <div class="flex items-center gap-2 text-dark-light2 font-medium">
        <span class="px-2 py-1">Ownership</span>
        <span class="grid place-items-center text-dark-lighter">/</span>
        <a :href="'{{ route('company.ownership', $company->ticker) }}?tab=' + tab?.key">
            <span class="px-2 py-1" x-text="tab?.title"></span>
        </a>
    </div>

    <div class="mt-6">
        <h1 class="font-bold text-xl">{{ $company->name }} ({{ $company->ticker }})</h1>
        <div class="mt-2 flex items-center gap-2 text-xs">
            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                CIK:
                <span class="text-blue font-semibold">{{ $company->cik }}</span>
            </div>

            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                FORM TYPE:
                <span class="text-blue font-semibold">4</span>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="['company' => $company]">
    </div>
</div>