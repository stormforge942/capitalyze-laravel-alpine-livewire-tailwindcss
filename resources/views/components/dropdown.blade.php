<div x-data="{
    dropdown: null,
    open: false,
    init() {
        this.dropdown = new Dropdown($refs.body, $refs.trigger, {
            placement: '{{ $placement }}',
            onShow: () => this.open = true,
            onHide: () => this.open = false,
        });

        $watch('open', value => {
            if (value) {
                this.dropdown.show()
            } else {
                this.dropdown.hide()
            }
        })
    },
}" @hide-dropdown="dropdown.hide()" x-modelable="open" {{ $attributes }}>
    <button class="dropdown-trigger {{ $fullWidthTrigger ? 'block w-full' : '' }}" x-ref="trigger">
        {{ $trigger ?? '' }}
    </button>

    <div class="z-[1000] hidden dropdown-body" x-ref="body">
        @if ($body ?? false)
            {{ $body }}
        @else
            <div class="bg-white rounded-lg border border-[#E8EBF2]" @if ($shadow) style="box-shadow: 0px 4px 8px 0px rgba(0, 0, 8, 0.08);" @endif>
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
