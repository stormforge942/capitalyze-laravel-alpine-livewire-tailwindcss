<div class="flex justify-center p-4">

    <div class="w-[600px] h-10 relative pt-8 pb-8"  x-data>
        <div class="relative flex items-center">
            <input type="text" wire:model="search" placeholder="Search Tickers..." class="input-field pr-10" wire:click="showText" x-on:click.away="$wire.call('hideText')">
            <svg class="absolute right-3 top-2.5 h-5 w-5 text-pg-primary-300 dark:text-pg-primary-200" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        @if($search && $results)
            <div class="result-container shadow">
                <table class="result-box">
                    <thead>
                        <tr>
                            <th class="text-left px-2 py-2">Ticker</th>
                            <th class="text-left px-2 py-2">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr wire:click="redirectToProduct('{{ $result->ticker }}')" class="hover:bg-gray-200 cursor-pointer">
                                <td class="text-left px-2 py-2 w-1/4">
                                    {{ $result->ticker }}
                                </td>
                                <td class="text-left px-2 py-2">
                                    {{ $result->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($showText && !$search )
            <div class="result-container shadow">
                <table class="result-box">
                    <tbody>
                        
                        <tr class="hover:bg-gray-200 cursor-pointer">
                            <td class="text-left px-2 py-2 w-1/4">
                                Search Tickers...
                            </td>
                        </tr>
                    
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('livewire:click', () => {
            @this.call('hideText');
        });

        window.addEventListener('click', (event) => {
            if (!event.target.closest('[wire\\:click]')) {
                @this.call('hideText');
            }
        });
    </script>
@endpush