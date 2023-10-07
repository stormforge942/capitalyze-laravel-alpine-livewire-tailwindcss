<?php

$attrs = $attrs ?? [];

$errorKey = $name ?? null;

$value = old($name);

if(isset($attrs['wire:model.defer'])) {
    $var = $attrs['wire:model.defer'];
    $value = $$var ?? $value;
}

?>

<div>
    <label
        class="{{ $class ?? '' }} block px-4 py-2 border @if ($errors->has($name)) border-danger @else border-[#D4DDD7] @endif focus-within:border-green-dark  rounded relative duration-100 ease-in-out">
        <input type="{{ $type ?? 'text' }}"
            class="moving-label-input p-0 h-6 w-full text-base mt-4 block border-none focus:ring-0 focus:outline-none peer"
            name="{{ $name }}" value="{{ $value }}" @if ($required ?? false) required @endif
            @if ($autofocus ?? false) autofocus @endif
            @foreach ($attrs ?? [] as $aKey => $aVal) {{ $aKey }}="{{ $aVal }}" @endforeach>

        <span
            class="text-gray-medium2 transition-all absolute left-4 @if ($value) top-4 text-sm @else top-[50%] @endif -translate-y-[50%] peer-focus-within:top-4 peer-focus-within:text-sm">
            {{ $label ?? '' }}@if($required ?? false)*@endif
        </span>
    </label>

    @error($name)
        <p class="mt-1 text-sm text-danger px-4">{{ $message }}</p>
    @enderror
</div>
