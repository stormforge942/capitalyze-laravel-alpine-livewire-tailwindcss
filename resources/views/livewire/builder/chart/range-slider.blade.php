<div class="years-range-wrapper -translate-y-[50%]" x-data="{
    value: null,
    show: false,
    max: null,
    min: null,
    init() {
        const dates = this._raw.dates[this.period] || []

        this.min = dates.length ? parseInt(dates[0].split('-')[0]) : 2001;
        this.max = dates.length ? parseInt(dates[dates.length - 1].split('-')[0]) : {{ date('Y') }};

        this.value = [...this.dateRange]

        this.$nextTick(() => {
            this.show = true;
            this.initSlider();
        })
    },

    initSlider() {
        const el = this.$el.querySelector('.range-slider');

        if (!el) return;

        const alpineThis = this;

        const dispatchValue = Alpine.debounce(
            (value) => alpineThis.$dispatch('range-updated', value),
            500
        );

        rangeSlider(el, {
            step: 1,
            min: 2001,
            max: {{ date('Y') }},
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
}" :class="!show ? 'invisible' : ''">
    <div class="dots-wrapper">
        <template x-for="item in items" :key="item">
            <span :class="isInRange(item) ? 'active-dots' : 'inactive-dots'"></span>
        </template>
    </div>
    <div class="range-slider" wire:ignore></div>
</div>
