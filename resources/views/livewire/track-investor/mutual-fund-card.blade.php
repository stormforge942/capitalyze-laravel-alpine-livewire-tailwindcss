<div
    class="{{ $hideIfNotFavorite && !$fund['isFavorite'] ? 'hidden' : '' }} bg-white rounded border-[0.5px] border-[#D4DDD7] px-4 py-6 overflow-hidden">
    <div class="flex items-center justify-between gap-2">
        <a href="{{ $url }}">
            <h4 class="text-blue font-semibold">{{ $fund['registrant_name'] }}</h4>
        </a>

        <?php
        $class = $fund['isFavorite'] ? 'bg-green-dark hover:bg-opacity-80' : 'bg-gray-100 hover:bg-gray-200';
        ?>

        <button class="h-6 w-6 rounded {{ $class }} transition disabled:pointer-events-none shrink-0"
            wire:click="toggle(@js($fund))"
            wire:loading.class="opacity-90 animate-pulse" wire:loading.attr="disabled">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="{{ $fund['isFavorite'] ? '#ffff' : 'none' }}">
                <path
                    d="M11.8272 7.29016C11.9043 7.15771 12.0957 7.15771 12.1728 7.29016L13.3524 9.31534C13.5219 9.60647 13.8061 9.8129 14.1353 9.8842L16.4259 10.3802C16.5757 10.4127 16.6349 10.5946 16.5327 10.7089L14.9712 12.4566C14.7467 12.7078 14.6382 13.0418 14.6721 13.377L14.9082 15.7088C14.9236 15.8613 14.7688 15.9737 14.6286 15.9119L12.4839 14.9668C12.1756 14.831 11.8244 14.831 11.5161 14.9668L9.37144 15.9119C9.23117 15.9737 9.07637 15.8613 9.09181 15.7088L9.3279 13.377C9.36183 13.0418 9.25331 12.7078 9.02883 12.4566L7.46727 10.7089C7.36514 10.5946 7.42427 10.4127 7.57408 10.3802L9.86465 9.8842C10.1939 9.8129 10.4781 9.60647 10.6476 9.31534L11.8272 7.29016Z"
                    stroke="{{ $fund['isFavorite'] ? '#ffff' : '#121A0F' }}" />
            </svg>
        </button>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-x-6 md:gap-x-8 gap-y-4">
        <div>
            <label class="font-normal text-sm text-dark-light2">Market Value</label>
            <div class="font-semibold text-base break-all">{{ niceNumber($fund['total_value']) }}</div>
        </div>
        <div>
            <label class="font-normal text-sm text-dark-light2">Holdings</label>
            <div class="font-semibold text-base break-all">{{ $fund['portfolio_size'] }}</div>
        </div>
        <div>
            <label class="font-normal text-sm text-dark-light2">CIK</label>
            <div class="font-semibold text-base break-all">{{ $fund['cik'] ?? '--' }}</div>
        </div>
        <div>
            <label class="font-normal text-sm text-dark-light2">Turnover</label>
            <div class="font-semibold text-base break-all">
                {{ niceNumber($fund['change_in_total_value']) }}
            </div>
        </div>
    </div>
</div>
