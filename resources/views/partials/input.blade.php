@php $error = $error ?? false; @endphp

<div>
    <label
        class="{{ $class ?? '' }} block px-4 py-2 border @if($error) border-danger @else border-gray-medium @endif rounded-md relative">
        <input type="{{ $type ?? 'text' }}"
            class="moving-label-input p-0 h-6 w-full text-base mt-4 block border-none focus:ring-0 focus:outline-none peer" @if($wire ?? false) wire:model.defer="{{ $wire }}" @endif>

        <span
            class="text-gray-medium2 transition-all absolute left-4 @if($$wire) top-4 text-sm @else top-[50%] @endif -translate-y-[50%] peer-focus-within:top-4 peer-focus-within:text-sm">
            {{ $label ?? '' }}
        </span>
    </label>

    @if($wire && $errors->has($wire))
    <p class="mt-1 text-sm text-danger px-4">{{ $errors->first() }}</p>
    @endif
</div>