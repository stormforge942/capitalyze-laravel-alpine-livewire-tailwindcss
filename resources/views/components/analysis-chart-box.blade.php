<div x-data="{
    hide: false,
    printChart() {
        window.printChart(this.$el.querySelector('canvas'))
    }
}" @download-chart="Livewire.emit('modal.open', 'upgrade-account-modal')"
    @print-chart="printChart">
    <div class="flex justify-end" x-show="hide" x-cloak @click="hide = false">
        <button class="bg-green-light flex items-center text-sm font-medium gap-3 pl-10 p-2"
            style="border-radius: 0 8px 2px 2px;">
            <span>Show Chart</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path
                    d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                    fill="#121A0F"></path>
            </svg>
        </button>
    </div>

    <div class="@if (!$enclosed) bg-white px-4 py-6 md:px-6 rounded-lg relative @endif" x-show="!hide"
        x-transition>
        <div class="absolute top-2 right-2 xl:top-3 xl:right-5">
            <x-dropdown placement="bottom-start" :shadow="true">
                <x-slot name="trigger">
                    <svg :class="open ? `rotate-90` : ''" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 21.998L15 21.998C20 21.998 22 19.998 22 14.998L22 8.99805C22 3.99805 20 1.99805 15 1.99805L9 1.99805C4 1.99805 2 3.99805 2 8.99805L2 14.998C2 19.998 4 21.998 9 21.998Z"
                            stroke="#121A0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="8" r="1" fill="#121A0F" />
                        <circle cx="12" cy="12" r="1" fill="#121A0F" />
                        <circle cx="12" cy="16" r="1" fill="#121A0F" />
                    </svg>
                </x-slot>
                <x-chart-options></x-chart-options>
            </x-dropdown>
        </div>

        <div x-data="{
            showLabel: $wire.entangle('chartConfig.showLabel', true),
            reverse: $wire.entangle('dateOrder', false),
            type: $wire.chartConfig?.type ? $wire.entangle('chartConfig.type', true) : '{{ $defaultType }}',
            data: @js($chart['data'] ?? []),
            init() {
                this.renderChart();
        
                this.$watch('type', () => this.renderChart())
        
                this.$watch('reverse', () => this.renderChart())
        
                this.$watch('showLabel', () => this.renderChart())
            },
            renderChart() {
                if (!window.analysisCharts) window.analysisCharts = {};
        
                window.analysisCharts?.['{{ $title }}']?.destroy();
        
                window.analysisCharts['{{ $title }}'] = window.analysisPage.{{ $function }}(this.$refs.canvas, this.data, {
                    type: this.type,
                    showLabel: this.showLabel,
                    reverse: this.reverse === 'ltl',
                })
            },
        }" wire:key="{{ $chart['key'] }}">
            <div class="flex items-center gap-x-5 justify-between">
                <div>
                    <p class="font-bold text-md">{{ $company['name'] }} ({{ $company['ticker'] }})</p>
                    <p class="mt-2 font-semibold text-blue">
                        {{ $title }}
                    </p>
                </div>

                <form class="flex items-center gap-8 text-sm text-gray-medium2 mr-10">
                    @if ($hasPercentageMix)
                        <label class="cursor-pointer flex items-center gap-1">
                            <input type="radio" value="values" class="custom-radio !h-4 !w-4 focus:ring-0"
                                :class="type === 'values' ? 'text-dark' : ''" x-model="type">
                            <span>Values</span>
                        </label>

                        <label class="cursor-pointer flex items-center gap-1">
                            <input type="radio" value="percentage" class="custom-radio !h-4 !w-4 focus:ring-0"
                                :class="type === 'percentage' ? 'text-dark' : ''" x-model="type">
                            <span>Percentage Mix</span>
                        </label>
                    @endif
                    @if ($toggle)
                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                            <input type="checkbox" value="yes" class="sr-only peer" :checked="showLabel"
                                @change="showLabel = $event.target.checked">
                            <div
                                class="w-6 h-2.5 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:-start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:shadow-md after:transition-all peer-checked:bg-dark-light2 peer-checked:after:bg-dark">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900">Show Labels</span>
                        </label>
                    @endif
                </form>
            </div>

            <div class="mt-6 w-full h-[300px] sm:h-[500px]" wire:ignore>
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>
    </div>
</div>
