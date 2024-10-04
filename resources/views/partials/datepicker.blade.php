<?php

$attrs = $attrs ?? [];

$errorKey = $name ?? null;

$value = old($name);

$disabled = $disabled ?? false;

if (isset($attrs['wire:model.defer'])) {
    $var = $attrs['wire:model.defer'];
    $value = $$var ?? $value;
}
?>

<div x-data="{
    open: false,
    hasContent: false,
    init() {
        const fn = () => {
            const input = this.$el.querySelector('input');
            if (!input) {
                clearInterval(fn);
                return;
            }
            this.hasContent = input.value.trim().length > 0;
        }

        const interval = setInterval(fn, 100);
    },
    openDatePicker() {
        this.open = true;

        const element = this.$refs.datepicker;
        const inputValue = this.$refs.dateInput.value; // Get the initial value from the input field

        const calendar = new VanillaCalendar(element, {
            actions: {
                clickDay: (e, dates) => {
                    this.open = false;
                    this.$refs.dateInput.value = dates[0];
                    this.$refs.dateInput.dispatchEvent(new Event('input'));

                    e.preventDefault();
                }
            },
            settings: {
                selected: { dates: [inputValue] },
            },
        });
        calendar.init();
    }
}" @click.away="open = false;">
    <label
        class="{{ $class ?? '' }} block px-4 py-2 border @if ($errors->has($name)) border-danger @else border-[#D4DDD7] @endif focus-within:border-green-dark rounded relative duration-100 ease-in-out">
        <input type="text" x-ref="dateInput"
            class="moving-label-input p-0 h-6 w-full text-base mt-4 block border-none focus:ring-0 focus:outline-none peer" 
            name="{{ $name }}" value="{{ $value }}" @click="openDatePicker()" readonly
            @foreach ($attrs ?? [] as $aKey => $aVal) {{ $aKey }}="{{ $aVal }}" @endforeach>

        <span
            class="text-gray-medium2 transition-all absolute left-4 -translate-y-[50%]"
            :class="{
                'top-4 text-sm': hasContent,
                'top-[50%]': !hasContent
            }">
            {{ $label ?? '' }}@if ($required ?? false)
                *
            @endif
        </span>

        <div x-show="open" class="absolute left-0 top-[100%] px-4 py-2 bg-white rounded-lg border border-blue z-[1000]">
            <div x-ref="datepicker"></div>
        </div>
    </label>

    @if ($showError ?? true)
        @error($name)
            <p class="mt-1 text-sm text-danger px-4">{{ $message }}</p>
        @enderror
    @endif
</div>
