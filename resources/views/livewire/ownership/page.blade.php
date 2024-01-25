<div x-data="{
    tab: null,
    get formType() {
        return $wire.formTypes[this.tab?.key || '{{ request('tab') }}']
    }
}" @tab-changed="tab = $event.detail;">
    <div class="mb-4 flex lg:hidden items-center justify-between">
        <h2 class="text-xl font-semibold text-blue">Ownership</h2>

        <x-download-data-buttons />
    </div>

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
                        <span class="font-semibold text-blue" x-text="formType"></span>
                    </div>
                @endif
            </div>
        </div>

        <x-download-data-buttons class="hidden lg:block" />
    </div>

    <div class="mt-6">
        <div id="ownership-tab">
            <livewire:tabs :tabs="$tabs" :data="['company' => $company]" :ssr="false">
        </div>
    </div>
</div>
