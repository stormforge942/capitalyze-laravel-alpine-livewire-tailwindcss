<div {{ $attributes->merge(['class' => 'flex items-center justify-between']) }}>
    <div class="text-lg md:text-xl">
        <h1 class="font-bold">{{ $company['name'] }} ({{ $company['ticker'] }})</h1>
        <p class="mt-2 flex items-center gap-1">
            <span class="font-bold">${{ number_format($latestPrice, 2) }}</span>
            <span class="text-md {{ $percentageChange >= 0 ? 'text-green' : 'text-red' }}">
                ({{ $percentageChange >= 0 ? '+' : '-' }}{{ abs($percentageChange) }}%)
            </span>
            <svg class="h-6 w-6 {{ $percentageChange >= 0 ? 'text-green' : 'text-red' }} fill-current" viewBox="0 0 16 16"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M9.33587 12.6669L3.33596 12.6669L3.33594 11.3336L8.00254 11.3335L8.0026 4.5523L5.36945 7.18547L4.42664 6.24264L8.66927 2L12.9119 6.24264L11.9691 7.18547L9.33594 4.55227L9.33587 12.6669Z" />
            </svg>
        </p>
    </div>

    <div>
        {{ $slot ?? '' }}
    </div>
</div>
