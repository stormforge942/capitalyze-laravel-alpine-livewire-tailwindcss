<div x-data="{ tab: null }" @tab-changed="tab = $event.detail;">
    <div class="mb-4 flex lg:hidden">
        <h2 class="text-xl font-semibold text-blue">Adviser</h2>
    </div>

    @livewire('investor-adviser.breadcrumb')

    <div class="mt-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold">{{ $adviser->legal_name }}</h1>
            <div class="flex flex-wrap items-center gap-2 mt-2 text-xs">
                <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                    CRD:
                    <span class="font-semibold text-blue">{{ $adviser['form_data']['Organization CRD#'] }}</span>
                </div>
            </div>
        </div>

        <x-download-data-buttons class="hidden lg:block" x-show="tab?.key === 'holdings'" x-cloak />
    </div>

    <div class="mt-6 text-[12px]" id="adviser-tab">
        <livewire:tabs :tabs="$tabs" :data="['adviser' => $adviser, 'company' => $company]" :ssr="false">
    </div>
</div>
