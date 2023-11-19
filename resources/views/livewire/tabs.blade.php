<x-primary-tabs :active="$active" :tabs="$tabs" @tab-changed="{{ $ssr ? '$wire.changeTab($event.detail.key)' : '' }}">
    <div class="place-items-center" wire:loading.grid>
        <span class="mx-auto simple-loader !text-green-dark"></span>
    </div>

    @if ($ssr)
        <div wire:loading.remove>
            @livewire($tabs[$active]['component'], ['data' => $data], key($active))
        </div>
    @else
        @foreach ($tabs as $key => $tab)
            <div x-show="active === '{{ $key }}'" x-cloak>
                @livewire($tabs[$key]['component'], ['data' => $data])
            </div>
        @endforeach
    @endif
</x-primary-tabs>
