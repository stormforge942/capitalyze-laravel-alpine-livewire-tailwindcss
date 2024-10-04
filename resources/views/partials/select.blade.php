<?php

$attrs = $attrs ?? [];

$errorKey = $name ?? null;

$filterable = $filterable ?? false;

$value = '';

if (isset($attrs['wire:model.defer'])) {
    $var = $attrs['wire:model.defer'];
    $value = $$var ?? $value;
}

?>

<div x-data="{
    open: false,
    selected: '{{ $value }}',
    search: '{{ $value }}',
    options: {{ json_encode($options) }},
    get filterOptions() {
        if (this.search === '') {
            return this.options;
        }
        return this.options.filter(option => option.toLowerCase().includes(this.search.toLowerCase()));
    },
    selectItem(e, option) {
        this.selected = option;
        this.search = option;
        this.open = false;
        
        this.$refs.hiddenInput.value = option;
        this.$refs.hiddenInput.dispatchEvent(new Event('input'));

        e.preventDefault();
    }
}" @click.away="open = false" @close.stop="open = false">
    <label class="{{ $class ?? '' }} block px-4 py-2 border @if ($errors->has($name)) border-danger @else border-[#D4DDD7] @endif focus-within:border-green-dark rounded relative duration-100 ease-in-out" @blur="open = false">
        <input type="text" x-model="search" @input="open = true" @click="open = true"
                class="p-0 h-6 w-full text-base mt-4 block border-none focus:ring-0 focus:outline-none peer"
                @keydown.enter.prevent="if(filterOptions.length === 1) { selected = filterOptions[0]; open = false; }" />
        <span
            class="text-gray-medium2 transition-all absolute -translate-y-[50%] peer-focus-within:top-4 peer-focus-within:text-sm"
            :class="{
                'top-4 text-sm': search || open,
                'top-[50%]': ! (search || open)
            }">
            {{ $label ?? '' }}@if ($required ?? false)
                *
            @endif
        </span>
        <svg class="pointer-events-none absolute right-0 top-[50%] -translate-y-[50%] mr-4 fill-current text-gray-700"
            width="24" height="24" viewBox="0 0 24 24">
            <path d="M7 10l5 5 5-5z" />
        </svg>

        <div x-show="open" class="absolute z-10 mt-3 w-full bg-white shadow-lg rounded -left-0.5 max-h-60 overflow-y-auto">
            <div class="py-2">
                <template x-for="option in filterOptions" :key="option">
                    <div @click="e => selectItem(e, option)"
                        class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                        :class="{'bg-gray-100': selected === option}">
                        <span x-text="option"></span>
                    </div>
                </template>
            </div>
        </div>
        <input x-ref="hiddenInput" type="hidden" name="{{ $name }}" :value="selected" @foreach ($attrs ?? [] as $aKey => $aVal) {{ $aKey }}="{{ $aVal }}" @endforeach />
    </label>

    @if ($showError ?? true)
        @error($name)
            <p class="mt-1 text-sm text-danger px-4">{{ $message }}</p>
        @enderror
    @endif
</div>
