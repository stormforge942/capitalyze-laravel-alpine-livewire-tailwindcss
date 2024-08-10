<?php

$attrs = $attrs ?? [];

$errorKey = $name ?? null;

$icon = $icon ?? null;

$value = old($name);

$disabled = $disabled ?? false;

if (isset($attrs['wire:model.defer'])) {
    $var = $attrs['wire:model.defer'];
    $value = $$var ?? $value;
}

$type = $type ?? 'text';
$passwordToggle = $type === 'password' && ($toggle ?? false);
?>

<div x-data="{
    toggle: false,
    hasContent: false,
    init() {
        const fn = setInterval(() => {
            const input = this.$el.querySelector('input');
            if (!input) {
                clearInterval(fn);
                return;
            }

            this.hasContent = input.value.length > 0;
        }, 100);
    }
}">
    <label
        class="{{ $class ?? '' }} block px-4 py-2 border @if ($errors->has($name)) border-danger @else border-[#D4DDD7] @endif  @if ($icon) pr-[36px] @endif focus-within:border-green-dark  rounded relative duration-100 ease-in-out">
        <input :type="toggle ? 'text' : '{{ $type }}'"
            class="moving-label-input p-0 @if ($passwordToggle) pr-8 @endif h-6 w-full text-base mt-4 block border-none focus:ring-0 focus:outline-none peer"
            name="{{ $name }}" value="{{ $value }}" @if ($autofocus ?? false) autofocus @endif
            @if ($disabled) disabled @endif
            @foreach ($attrs ?? [] as $aKey => $aVal) {{ $aKey }}="{{ $aVal }}" @endforeach>

        <span
            class="text-gray-medium2 transition-all absolute left-4 -translate-y-[50%] peer-focus-within:top-4 peer-focus-within:text-sm"
            :class="{
                'top-4 text-sm': hasContent,
                'top-[50%]': !hasContent
            }">
            {{ $label ?? '' }}@if ($required ?? false)
                *
            @endif
        </span>

        @if ($passwordToggle)
            <button type="button" class="absolute right-0 top-[50%] -translate-y-[50%]" @click="toggle = !toggle">
                <template x-if="!toggle">
                    <svg class="mr-4" width="22" height="13" viewBox="0 0 22 13" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.34268 12.7819L6.41083 12.2642L7.1983 9.3254C6.00919 8.8874 4.91661 8.2498 3.96116 7.4534L1.80783 9.6067L0.393621 8.1925L2.54695 6.0392C1.35581 4.6103 0.520141 2.87466 0.175781 0.968182L2.14386 0.610352C2.90289 4.8126 6.57931 8.0001 11.0002 8.0001C15.4211 8.0001 19.0976 4.8126 19.8566 0.610352L21.8247 0.968182C21.4803 2.87466 20.6446 4.6103 19.4535 6.0392L21.6068 8.1925L20.1926 9.6067L18.0393 7.4534C17.0838 8.2498 15.9912 8.8874 14.8021 9.3254L15.5896 12.2642L13.6578 12.7819L12.87 9.8418C12.2623 9.9459 11.6376 10.0001 11.0002 10.0001C10.3629 10.0001 9.7381 9.9459 9.1305 9.8418L8.34268 12.7819Z"
                            fill="#3561E7" />
                    </svg>
                </template>

                <template x-if="toggle">
                    <svg class="mr-4" width="22" height="18" viewBox="0 0 22 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.9983 0C16.3904 0 20.8764 3.87976 21.8169 9C20.8764 14.1202 16.3904 18 10.9983 18C5.60617 18 1.1202 14.1202 0.179688 9C1.1202 3.87976 5.60617 0 10.9983 0ZM10.9983 16C15.2339 16 18.8583 13.052 19.7757 9C18.8583 4.94803 15.2339 2 10.9983 2C6.76265 2 3.13827 4.94803 2.22083 9C3.13827 13.052 6.76265 16 10.9983 16ZM10.9983 13.5C8.51303 13.5 6.49831 11.4853 6.49831 9C6.49831 6.51472 8.51303 4.5 10.9983 4.5C13.4835 4.5 15.4983 6.51472 15.4983 9C15.4983 11.4853 13.4835 13.5 10.9983 13.5ZM10.9983 11.5C12.379 11.5 13.4983 10.3807 13.4983 9C13.4983 7.6193 12.379 6.5 10.9983 6.5C9.61765 6.5 8.49831 7.6193 8.49831 9C8.49831 10.3807 9.61765 11.5 10.9983 11.5Z"
                            fill="#3561E7" />
                    </svg>
                </template>
            </button>
        @endif

        @if ($icon)
            <img src="{{ asset($icon) }}" class="absolute pr-2 right-0 top-[50%] -translate-y-[50%]" width="32px"
                height="32px" />
        @endif
    </label>

    @if ($showError ?? true)
        @error($name)
            <p class="mt-1 text-sm text-danger px-4">{{ $message }}</p>
        @enderror
    @endif
</div>
