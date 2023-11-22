<div x-data="{
    dropdown: null,
    init() {
        this.dropdown = new Dropdown($refs.body, $refs.trigger, {
            placement: '{{ $placement }}',
        });
    }
}">
    <button ref="trigger">
        {{ $trigger ?? '' }}
    </button>

    <div class="z-10 hidden" ref="body">
        @if ($body ?? false)
        @else
            <div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-[#D4DDD7]']) }}>
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
