<div class="years-range-wrapper" x-data="{
    value: @json($value),
    show: false,
    init() {
        if (!this.value) {
            this.value = [{{ $min }}, {{ $max }}];
        }

        this.$nextTick(() => {
            this.show = true;
            this.initSlider();
        })
    },

    initSlider() {
        const el = this.$el.querySelector('.range-slider');

        if (!el) return;

        let rangeMin = {{ $min }};
        let rangeMax = {{ $max }};

        const alpineThis = this;

        const dispatchValue = Alpine.debounce(
            (value) => alpineThis.$dispatch('range-updated', value),
            500
        );

        rangeSlider(el, {
            step: 1,
            min: rangeMin,
            max: rangeMax,
            value: @json($value),
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
}" {{ $attributes }} :class="!show ? 'invisible' : ''">
    <div class="dots-wrapper">
        @foreach (range($min, $max) as $item)
            <span :class="isInRange({{ $item }}) ? 'active-dots' : 'inactive-dots'"></span>
        @endforeach
    </div>
    <div class="range-slider" wire:ignore></div>
</div>
