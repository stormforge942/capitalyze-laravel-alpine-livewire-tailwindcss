<div class="lg:px-8" x-data="{ tab: null }" @tab-changed="tab = $event.detail;">
    <div class="flex items-center gap-2 font-medium text-dark-light2">
        <span class="px-2 py-1">Ownership</span>
        <span class="grid place-items-center text-dark-lighter">/</span>
        <a :href="'{{ route('company.ownership', $company->ticker) }}?tab=' + tab?.key">
            <span class="px-2 py-1" x-text="tab?.title"></span>
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M10.2536 8L6.25365 12L5.32031 11.0667L8.38698 8L5.32031 4.93333L6.25365 4L10.2536 8Z"
                fill="#464E49" />
        </svg>
    </div>

    <div class="mt-6">
        <h1 class="text-xl font-bold">{{ $company->name }} ({{ $company->ticker }})</h1>
        <div class="flex items-center gap-2 mt-2 text-xs">
            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                CIK:
                <span class="font-semibold text-blue">{{ $company->cik }}</span>
            </div>

            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                FORM TYPE:
                <span class="font-semibold text-blue">4</span>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="['company' => $company]">
    </div>
</div>