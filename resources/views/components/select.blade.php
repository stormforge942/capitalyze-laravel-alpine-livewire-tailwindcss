<select class="border-[0.5px] border-solid border-[#93959880] p-2 rounded-full" {{ $attributes }}>
    @if ($placeholder)
        <option value="" disabled>{{ $placeholder }}</option>
    @endif
    @foreach ($options as $key => $label)
        <option value="{{ $key }}">{{ $label }}</option>
    @endforeach
</select>
