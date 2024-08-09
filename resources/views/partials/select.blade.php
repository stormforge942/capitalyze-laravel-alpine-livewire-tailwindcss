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
    search: '',
    options: {{ json_encode($options) }},
    get filterOptions() {
        if (this.search === '') {
            return this.options;
        }
        return this.options.filter(option => option.toLowerCase().includes(this.search.toLowerCase()));
    }
}" @click.away="open = false; search = '';" @close.stop="open = false; search = '';">
    <label class="{{ $class ?? '' }} block px-4 py-2 border @if ($errors->has($name)) border-danger @else border-[#D4DDD7] @endif focus-within:border-green-dark rounded relative duration-100 ease-in-out">
        <div @click="open = !open; @if ($filterable) $nextTick(() => { if(open) $refs.search.focus() }) @endif"
            class="appearance-none block w-full bg-white border-none rounded leading-tight focus:outline-none focus:ring-0 cursor-pointer">
            <span x-text="selected"
                class="block text-base mt-4 h-6"></span>
            <span x-ref="dropdownLabel"
                class="text-gray-medium2 transition-all absolute left-4 -translate-y-[50%] peer-focus-within:top-4 peer-focus-within:text-sm"
                :class="selected ? 'top-4 text-sm' : 'top-[50%]'">
                {{ $label ?? '' }}@if ($required ?? false)
                    *
                @endif
            </span>
            <svg class="pointer-events-none absolute right-0 top-[50%] -translate-y-[50%] mr-4 fill-current text-gray-700"
                width="24" height="24" viewBox="0 0 24 24">
                <path d="M7 10l5 5 5-5z" />
            </svg>
        </div>
        <div x-show="open" class="absolute z-10 mt-3 w-full bg-white shadow-lg rounded -left-0.5">
            @if ($filterable)
                <input x-ref="search" type="text" @input="search = $event.target.value" placeholder="Search..." :value="search" class="px-4 py-2 w-full border-b border-gray-200 focus:outline-none" />
            @endif
            <div class="max-h-60 overflow-y-auto">
                <template x-for="option in filterOptions" :key="option">
                    <div @click="selected = option; search = ''; open = false; $refs.hiddenInput.value = selected; $refs.hiddenInput.dispatchEvent(new Event('input'))"
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
