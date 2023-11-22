<div x-data="{
    dropdown: null,
    open: false,
    init() {
        this.dropdown = new Dropdown($refs.body, $refs.trigger, {
            placement: '{{ $placement }}',
            onShow: () => this.open = true,
            onHide: () => this.open = false,
        });
    }
}">
    <button x-ref="trigger">
        {{ $trigger ?? '' }}
    </button>

    <div class="z-10 hidden" x-ref="body" @if($shadow) style="box-shadow: 0px 4px 8px 0px rgba(0, 0, 8, 0.08);" @endif>
        @if ($body ?? false)
        @else
            <div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-[#D4DDD7]']) }}>
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
