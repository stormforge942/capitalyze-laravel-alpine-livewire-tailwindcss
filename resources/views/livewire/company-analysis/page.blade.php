<div>
    <x-company-info-header :company="['name' => $company->name, 'ticker' => $company->ticker]">
        <x-download-data-buttons />
    </x-company-info-header>

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="['company' => $company->toArray()]">
        </livewire:tabs>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
@endpush
