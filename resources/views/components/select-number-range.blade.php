<div x-data="{
    showDropdown: false,
    value: null,
    tmpValue: {
        min: 0,
        max: 0,
    },
    get valueText() {
        if (!this.value) {
            return '{{ $label }}'
        }

        return `{{ $prefix }}${this.value[0]}{{ $unit }} - {{ $prefix }}${this.value[1]}{{ $unit }}`
    },
    init() {
        $watch('showDropdown', () => {
            const value = this.value ? this.value : [0, 0];

            this.tmpValue = {
                min: value[0],
                max: value[1],
            }
        })
    },
    updateValue() {
        this.tmpValue.min = Number(this.tmpValue.min);
        this.tmpValue.max = Number(this.tmpValue.max);

        this.tmpValue.max = this.tmpValue.max < this.tmpValue.min ? this.tmpValue.min : this.tmpValue.max;
        this.value = this.tmpValue.min == 0 && this.tmpValue.max == 0 ? null : [this.tmpValue.min, this.tmpValue.max];

        this.showDropdown = false;
    },
}" x-modelable="value" {{ $attributes->merge(['class' => 'inline-block']) }}>
    <x-dropdown x-model="showDropdown" placement="bottom-start">
        <x-slot name="trigger">
            <div class="border-[0.5px] border-[#93959880] p-2 rounded-full flex items-center gap-x-1"
                :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                <span class="text-sm truncate" x-text="valueText">
                </span>

                <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </span>
            </div>
        </x-slot>

        <form class="w-[20rem]" @submit.prevent="updateValue">
            <div class="px-6 pt-6">
                <div class="flex justify-between">
                    <span class="font-medium text-base">{{ $longLabel ?? $label }}</span>

                    <button @click="dropdown.hide()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#C22929" />
                        </svg>
                    </button>
                </div>

                <div class="py-4">
                    <div class="flex items-center justify-between">
                        <input class="flex-1 w-16 rounded-sm border-2 border-gray-medium2" type="number"
                            {{ $allowNegative ? '' : 'min=0' }} step="1" x-model="tmpValue.min"
                            :max="tmpValue.max">
                        <span class="px-5">-</span>
                        <input class="flex-1 w-16 rounded-sm border-2 border-gray-medium2" type="number" step="1"
                            x-model="tmpValue.max" :min="tmpValue.min">
                    </div>

                    <button type="button" class="text-sm mt-1 hover:underline text-red"
                        @click="tmpValue.min = 0; tmpValue.max = 0;" x-show="tmpValue.min != 0 || tmpValue.max != 0"
                        x-cloak>Clear</button>
                </div>
            </div>

            <div class="p-6">
                <button type="submit"
                    class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-gray-medium2 text-base">
                    Show Result
                </button>
            </div>
        </form>
    </x-dropdown>
</div>
