<div x-data="{
    dropdown: null,
    open: false,
    init() {
        this.$nextTick(() => {
            const body = document.getElementById('{{ $id }}')

            this.dropdown = new Dropdown(body, $refs.trigger, {
                placement: '{{ $placement }}',
                offsetDistance: {{ $offsetDistance }},
                onShow: () => this.open = true,
                onHide: () => this.open = false,
            });
        })

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

    @if ($teleport)
        <template x-teleport="body">
    @endif
    
    <div class="z-[1000] hidden dropdown-body" id="{{ $id }}">
        @if ($body ?? false)
            {{ $body }}
        @else
            <div class="bg-white rounded-lg border border-[#EDF4ED]"
                @if ($shadow) style="box-shadow: 0px 4px 8px 0px rgba(0, 0, 8, 0.08);" @endif>
                {{ $slot }}
            </div>
        @endif
    </div>

    @if ($teleport)
        </template>
    @endif
</div>
