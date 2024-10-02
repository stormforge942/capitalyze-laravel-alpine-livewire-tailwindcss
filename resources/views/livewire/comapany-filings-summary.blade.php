<div class="flex flex-col">
    <div class="flex flex-col mx-0 sm:mx-6 md:lg-0 ml-0">
        <x-company-info-header :company="['name' => $company->name, 'ticker' => $company->ticker]">
            <x-download-data-buttons />
        </x-company-info-header>


        <div class="mt-6">
            <x-primary-tabs :tabs="$tabs" :active="$tabName" @tab-changed="window.updateQueryParam('{{ $tabName }}', ''); $wire.setTabName($event.detail.key)"
                :wire:key="$tabName">
                <div>
                    <div wire:loading.remove>
                        @if ($tabName === 'earning-presentations')
                            <livewire:filings-summary.earning-presentations :ticker="$company->ticker" />
                        @else
                            <livewire:is :component="'filings-summary.' . $tabName" :company="$company" :ticker="$ticker" :tab="$selectedSubTabs[$tabName] ?? null" :wire:key="$tabName" />
                        @endif
                    </div>

                    <div class="place-items-center" wire:loading.grid>
                        <span class="mx-auto simple-loader !text-green-dark"></span>
                    </div>
                </div>
            </x-primary-tabs>
        </div>
    </div>
</div>
