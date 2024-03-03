<div>
    <div class="mb-6">
        <h1 class="text-xl font-bold">Chart</h1>
        <p class="mt-2 text-dark-light2">Build custom charts to visualize financial data across companies</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div>
            <livewire:builder.select-company />
        </div>

        <div>
            <livewire:builder.select-chart-metrics />
        </div>
    </div>

    <x-filter-box class="mt-6">
        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Period Type</span>
            <x-select placeholder="Period Type" :options="['Annual', 'Quarterly']"></x-select>
        </div>

        <div class="flex-1 -translate-y-[50%]">
            <x-range-slider :min="2005" :max="(int) date('Y')" :value="[2018, (int) date('Y')]"></x-range-slider>
        </div>

        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Unit Type</span>
            <x-select placeholder="Unit Type" :options="['Thousands', 'Millions', 'Billions']"></x-select>
        </div>

        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Decimal</span>
            <x-select-decimal-places></x-select-decimal-places>
        </div>
    </x-filter-box>

    <div class="mt-6 bg-white p-6 relative rounded-lg" x-data="{
        subSubTab: 'single-panel',
        tabs: {
            'single-panel': 'Single Panel',
            'multi-security': 'Multi Security',
            'multi-metric': 'Multi Metric',
        }
    }">
        <div class="flex items-center justify-between">
            <div
                class="flex items-center w-full max-w-[400px] gap-x-1 border border-[#D4DDD7] rounded bg-gray-light font-medium">
                <template x-for="(tab, key) in tabs">
                    <button class="py-2 rounded flex-1 transition"
                        :class="subSubTab === key ? 'bg-[#DCF6EC] border border-[#52D3A2] -m-[1px]' : ''"
                        @click="subSubTab = key" x-text="tab"></button>
                </template>
            </div>
            <div class="flex items-center gap-x-5 justify-between">
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

                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                    <input type="checkbox" value="yes" class="sr-only peer" :checked="showLabel"
                        @change="showLabel = $event.target.checked">
                    <div
                        class="w-6 h-2.5 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:-start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:shadow-md after:transition-all peer-checked:bg-dark-light2 peer-checked:after:bg-dark">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900">Show Labels</span>
                </label>
            </div>
        </div>

        <div class="mt-6 h-[400px] bg-gray-100">

        </div>
    </div>
</div>
