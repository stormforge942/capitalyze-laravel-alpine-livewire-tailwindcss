<div class="mt-2">
    <div>
        <h1 class="text-lg font-bold md:text-xl">{{ $company->name }} ({{ $company->ticker }})</h1>
        <p class="mt-2 flex items-center gap-1">
            <span class="text-lg font-bold md:text-xl">${{ number_format($cost) }}</span>
            <span class="{{ $dynamic >= 0 ? 'text-green' : 'text-danger' }}">
                ({{ $dynamic >= 0 ? '+' : '-' }}{{ abs($dynamic) }}%)
            </span>
        </p>
    </div>

    <div class="mt-7">
        <livewire:tabs :tabs="$tabs" :data="$tabData" :ssr="false">
    </div>
</div>