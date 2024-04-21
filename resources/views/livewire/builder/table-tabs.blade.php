<div class="flex items-center gap-x-6 overflow-x-auto text-sm+ whitespace-nowrap" wire:init="init">
    @foreach ($tabs as $tab)
        <div class="flex items-center gap-2" x-data="{
            value: '{{ $tab['name'] }}',
            edit: false,
            save() {
                this.edit = false;
                if (this.value.trim()) {
                    $wire.updateTab({{ $tab['id'] }}, this.value)
                } else {
                    this.value = '{{ $tab['name'] }}'
                }
            }
        }" wire:key="{{ $tab['id'] }} - {{ $tab['name'] }}">
            <template x-if="!edit">
                <a href="#" class=" {{ $tab['id'] === $activeTab ? 'text-blue' : '' }}"
                    @click.prevent="$wire.changeTab({{ $tab['id'] }})" x-text="value"></a>
            </template>
            <template x-if="edit">
                <input type="text" x-model="value" class="h-6 px-2 w-36"
                    @keyup.escape="edit = false; value = '{{ $tab['name'] }}'" @keyup.enter="save" x-on:blur="save"
                    x-ref="input">
            </template>
            <button @click="edit = true; $nextTick(() => $refs.input?.focus())">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.27614 10.595L11.0375 3.83354L10.0947 2.89072L3.33333 9.65217V10.595H4.27614ZM4.82843 11.9283H2V9.09984L9.62333 1.47651C9.88373 1.21616 10.3058 1.21616 10.5661 1.47651L12.4518 3.36213C12.7121 3.62248 12.7121 4.04459 12.4518 4.30494L4.82843 11.9283ZM2 13.2616H14V14.595H2V13.2616Z"
                        fill="#3561E7" />
                </svg>
            </button>
            <button type="button" @click="confirm('Are you sure?') ? $wire.deleteTab({{ $tab['id'] }}) : null">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8 13C5.23857 13 3 10.7614 3 8C3 5.23857 5.23857 3 8 3C10.7614 3 13 5.23857 13 8C13 10.7614 10.7614 13 8 13ZM8 12C10.2092 12 12 10.2092 12 8C12 5.79086 10.2092 4 8 4C5.79086 4 4 5.79086 4 8C4 10.2092 5.79086 12 8 12ZM8 7.2929L9.4142 5.87868L10.1213 6.58578L8.7071 8L10.1213 9.4142L9.4142 10.1213L8 8.7071L6.58578 10.1213L5.87868 9.4142L7.2929 8L5.87868 6.58578L6.58578 5.87868L8 7.2929Z"
                        fill="#C22929" />
                </svg>
            </button>
        </div>
    @endforeach

    <button class="flex items-center gap-2 hover:opacity-70 transition-all" wire:click="addTab">
        <span class="font-semibold">New Table</span>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M8.0026 14.6693C4.3207 14.6693 1.33594 11.6845 1.33594 8.0026C1.33594 4.3207 4.3207 1.33594 8.0026 1.33594C11.6845 1.33594 14.6693 4.3207 14.6693 8.0026C14.6693 11.6845 11.6845 14.6693 8.0026 14.6693ZM7.33594 7.33594H4.66927V8.66927H7.33594V11.3359H8.66927V8.66927H11.3359V7.33594H8.66927V4.66927H7.33594V7.33594Z"
                fill="#121A0F" />
        </svg>
    </button>
</div>
