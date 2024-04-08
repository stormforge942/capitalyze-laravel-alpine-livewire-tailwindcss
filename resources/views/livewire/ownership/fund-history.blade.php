<div class="flex flex-col h-full">
    <div class="bg-gray-light p-6" wire:init="load">
        @if ($loading)
            <div class="h-40 grid place-items-center">
                <span class="mx-auto simple-loader text-green"></span>
            </div>
        @else
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-extrabold">History</h3>
                <button class="flex items-center gap-x-1 text-red font-semibold text-sm" wire:click="$emit('modal.close')">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.9987 14.6663C4.3168 14.6663 1.33203 11.6815 1.33203 7.99967C1.33203 4.31777 4.3168 1.33301 7.9987 1.33301C11.6806 1.33301 14.6654 4.31777 14.6654 7.99967C14.6654 11.6815 11.6806 14.6663 7.9987 14.6663ZM7.9987 7.05687L6.11308 5.17125L5.17027 6.11405L7.0559 7.99967L5.17027 9.88527L6.11308 10.8281L7.9987 8.94247L9.8843 10.8281L10.8271 9.88527L8.9415 7.99967L10.8271 6.11405L9.8843 5.17125L7.9987 7.05687Z"
                            fill="#C22929" />
                    </svg>
    
                    <span>Close</span>
                </button>
            </div>
    
            <div class="mt-6 mb-5 space-y-6">
                <div class="bg-white rounded-lg p-6" x-data="{
                    init() {
                        window.ownership.initFundHistoryChart($refs.canvas, $wire.chartData)
                    }
                }">
                    <h4 class="font-extrabold mb-6">{{ $company['name'] }}</h4>
    
                    <div style="height: 300px"> 
                        <canvas id="fundHistoryChartCanvas" x-ref="canvas"></canvas>
                    </div>
                </div>
    
                <livewire:ownership.fund-history-table :cik="$fund" :company="$company['symbol']" />
            </div>
        @endif
    </div>
</div>
