<div class="years-range-wrapper" x-data="{
    value: @json($value),
    show: false,
    min: {{ $min }},
    max: {{ $max }},
    init() {
        if (!this.value) {
            this.value = [this.min, this.max];
        }

        this.$nextTick(() => {
            this.show = true;
            this.initSlider();
        })
    },

    initSlider() {
        const el = this.$el.querySelector('.range-slider');

        if (!el) return;

        let rangeMin = this.min;
        let rangeMax = this.max;

        const alpineThis = this;

        const dispatchValue = Alpine.debounce(
            (value) => alpineThis.$dispatch('range-updated', value),
            500
        );

        rangeSlider(el, {
            step: 1,
            min: rangeMin,
            max: rangeMax,
            value: [...this.value],
            rangeSlideDisabled: true,
            onInput: (value) => {
                this.value = value;
                dispatchValue(value);
            }
        });
    },

    isInRange(item) {
        return item >= this.value[0] && item <= this.value[1];
    },

    get items() {
        return Array.from({ length: this.max - this.min + 1 }, (_, i) => i + this.min);
    }
}" {{ $attributes }} :class="!show ? 'invisible' : ''">
    <div class="dots-wrapper">
        <template x-for="item in items" :key="item">
            <span :class="isInRange(item) ? 'active-dots' : 'inactive-dots'"></span>
        </template>
    </div>
    <div class="range-slider" wire:ignore></div>
</div>
