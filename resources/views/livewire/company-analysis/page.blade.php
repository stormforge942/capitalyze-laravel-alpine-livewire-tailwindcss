<div>
    <x-company-info-header :company="['name' => $company->name, 'ticker' => $company->ticker]">
        <x-download-data-buttons />
    </x-company-info-header>

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="['company' => $company->toArray()]">
        </livewire:tabs>
    </div>
</div>