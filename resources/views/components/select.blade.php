<div x-data="{
    dropdown: null,
    isVisible: false,
    name: '{{ $name }}',
    value: '{{ $value }}',
    tmpValue: '{{ $value }}',
    options: @js($options),
    placeholder: '{{ $placeholder }}',
    init() {        
        this.dropdown = new Dropdown($refs.body, $refs.trigger, {
            placement: 'bottom-start',
            onShow: () => {
                this.isVisible = true
                this.tmpValue = this.value
            },
            onHide: () => {
                this.isVisible = false
                this.tmpValue = this.value
            },
        })

        $watch('value', (newVal, oldVal) => {
            if (newVal !== oldVal) {
                $dispatch('input', newVal)
            }
        })
    }
}" class="inline-block">
    <div x-modelable="value" {{ $attributes }}>
        <button class="border-[0.5px] border-[#93959880] p-2 rounded-full flex items-center gap-x-1"
        :class="isVisible ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'"
            x-ref="trigger">
            <span class="font-medium" x-text="value ? options[value] : placeholder">
            </span>

            <span :class="isVisible ? 'rotate-180' : ''" class="transition-transform shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                        fill="#121A0F" />
                </svg>
            </span>
        </button>

        <div class="z-10 hidden w-[20rem] sm:w-[26rem] p-6 bg-white rounded-lg border border-[#D4DDD7]" x-ref="body">
            <div class="flex justify-between gap-2">
                <span x-text="placeholder"></span>

                <button @click="dropdown.hide()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                            fill="#686868" />
                    </svg>
                </button>
            </div>

            <div class="max-h-[19rem] space-y-2 overflow-y-auto">
                <template x-for="(label, key) in options" :key="key">
                    <label class="cursor-pointer rounded flex items-center p-4 hover:bg-green-light gap-x-4">
                        <input type="radio" :name="name" :value="key"
                            class="custom-radio border-dark focus:ring-0" x-model="tmpValue">

                        <span x-text="label">label</span>
                    </label>
                </template>
            </div>

            <div class="pt-6">
                <button type="button" class="w-full px-4 py-3 text-white font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5]"
                    @click="value = tmpValue; dropdown.hide()" :disabled="value === tmpValue">
                    Show Result
                </button>
            </div>
        </div>
    </div>
</div>
