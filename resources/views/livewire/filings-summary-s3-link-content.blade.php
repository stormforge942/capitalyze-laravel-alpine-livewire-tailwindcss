<x-wire-elements-pro::tailwind.slide-over>
    <div wire:init="load">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div wire:loading.remove>
            @if ($content)
                <div>
                    {!! $content !!}
                </div>


                @if (count($pages) > 3)
                    <div class="mt-5 flex justify-center py-3">
                        <nav class="isolate flex flex-wrap -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            @foreach ($pages as $_page)
                                @if ($_page['label'] === '&laquo; Previous')
                                    <button type="button" wire:click.prevent="load({{ $page - 1 }})"
                                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @disabled($page <= 1)>
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @elseif($_page['label'] === 'Next &raquo;')
                                    <button type="button" wire:click.prevent="load({{ $page + 1 }})"
                                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @disabled($page >= $numberOfPages)>
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @else
                                    <button type="button" wire:click.prevent="load({{ intval($_page['label']) }})"
                                        @class([
                                            'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex' => !$_page[
                                                'active'
                                            ],
                                            'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' =>
                                                $_page['active'],
                                        ])>
                                        {{ $_page['label'] }}
                                    </button>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                @endif
            @else
                <div class="text-center text-gray-500">
                    No content found
                </div>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
