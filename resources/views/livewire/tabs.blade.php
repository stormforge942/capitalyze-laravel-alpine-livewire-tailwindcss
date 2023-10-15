<div>
    <div class="border border-[#D4DDD7] rounded bg-white w-full flex items-center gap-2 p-1 overflow-x-auto"
        x-data="{ active: $wire.active }" x-cloak>
        @foreach ($tabs as $key => $tab)
            <button class="min-w-[250px] px-3 py-1.5 text-center rounded transition"
                :class="{
                    'bg-green-dark font-semibold': active ===
                        '{{ $key }}',
                    'font-medium text-gray-medium2 hover:bg-gray-light': active !==
                        '{{ $key }}'
                }"
                @click="(e) => {
                    active = '{{ $key }}'; 
                    $wire.changeTab('{{ $key }}');
                    e.target.scrollIntoView({behavior: 'smooth' , block: 'center' })
                }">
                {{ $tab['title'] }}
            </button>
        @endforeach
    </div>

    <div class="mt-6">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>

        <div wire:loading.remove>
            @livewire($tabs[$active]['component'], ['data' => $data], key($active))
        </div>
    </div>
</div>
