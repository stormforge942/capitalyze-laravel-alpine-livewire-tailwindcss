<div x-data="{ tab: null }" @tab-changed="tab = $event.detail;">
    <h2 class="block mb-4 text-xl font-semibold lg:hidden text-blue">Ownership</h2>

    @livewire('ownership.breadcrumb')

    <div class="mt-6 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold md:text-xl">{{ $company->name }} ({{ $company->ticker }})</h1>
            <div class="flex items-center gap-2 mt-2 text-xs">
                <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                    CIK:
                    <span class="font-semibold text-blue">{{ $company->cik }}</span>
                </div>

                @if (count($formTypes))
                    <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                        FORM TYPE:
                        <span class="font-semibold text-blue">{{ implode(',', $formTypes) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <livewire:download-data-buttons />
        </div>
    </div>

    <div class="mt-6">
        <div id="ownership-tab">
            <livewire:tabs :tabs="$tabs" :data="['company' => $company]" :ssr="false">
        </div>
    </div>
</div>
