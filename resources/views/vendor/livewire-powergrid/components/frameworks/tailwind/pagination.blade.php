<div class="items-center justify-between sm:flex text-base">
    <div class="items-center justify-between w-full sm:flex-1 sm:flex">
        @if ($recordCount === 'full')
            <div>
                <div class="mr-2 leading-5 text-center text-pg-primary-700 dark:text-pg-primary-300 sm:text-right">
                    {{ trans('livewire-powergrid::datatable.pagination.showing') }}
                    <span class="font-semibold firstItem">{{ $paginator->firstItem() }}</span>
                    {{ trans('livewire-powergrid::datatable.pagination.to') }}
                    <span class="font-semibold lastItem">{{ $paginator->lastItem() }}</span>
                    {{ trans('livewire-powergrid::datatable.pagination.of') }}
                    <span class="font-semibold total">{{ $paginator->total() }}</span>
                    {{ trans('livewire-powergrid::datatable.pagination.results') }}
                </div>
            </div>
        @elseif($recordCount === 'short')
            <div>
                <p class="mr-2 leading-5 text-center text-pg-primary-700 dark:text-pg-primary-300">
                    <span class="font-semibold firstItem"> {{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-semibold lastItem"> {{ $paginator->lastItem() }}</span>
                    |
                    <span class="font-semibold total"> {{ $paginator->total() }}</span>

                </p>
            </div>
        @elseif($recordCount === 'min')
            <div>
                <p class="mr-2 leading-5 text-center text-pg-primary-700 dark:text-pg-primary-300">
                    <span class="font-semibold firstItem"> {{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-semibold lastItem"> {{ $paginator->lastItem() }}</span>
                </p>
            </div>
        @endif

        @if ($paginator->hasPages() && $recordCount != 'min')
            <nav role="navigation" aria-label="Pagination Navigation" class="items-center justify-between sm:flex">
                <div class="flex flex-wrap justify-center items-center mt-2 md:flex-none md:justify-end sm:mt-0">
                    @if (!$paginator->onFirstPage())
                        <a class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300"
                            @click="scrollToHead(); $wire.gotoPage(1)">
                            <x-heroicon-o-chevron-double-left class="h-4 w-4" />
                        </a>

                        <a class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300"
                            @click="scrollToHead(); $wire.previousPage()" rel="next">
                            <x-heroicon-o-chevron-left class="h-4 w-4" />
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($paginator->currentPage() > 3 && $page === 2)
                                    <div class="mx-1 mt-1 text-pg-primary-800 dark:text-pg-primary-300">
                                        <span class="font-bold">.</span>
                                        <span class="font-bold">.</span>
                                        <span class="font-bold">.</span>
                                    </div>
                                @endif

                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="px-2 py-1 m-1 text-center text-blue-600 rounded cursor-pointer border-1 dark:bg-pg-primary-700 dark:text-dark">{{ $page }}</span>
                                @elseif (
                                    $page === $paginator->currentPage() + 1 ||
                                        $page === $paginator->currentPage() + 2 ||
                                        $page === $paginator->currentPage() - 1 ||
                                        $page === $paginator->currentPage() - 2)
                                    <a class="min-w-[35px] px-2 py-1 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300"
                                        @click="scrollToHead(); $wire.gotoPage({{ $page }})">{{ $page }}</a>
                                @endif

                                @if ($paginator->currentPage() < $paginator->lastPage() - 2 && $page === $paginator->lastPage() - 1)
                                    <div class="mx-1 mt-1 text-pg-primary-600 dark:text-pg-primary-300">
                                        <span>.</span>
                                        <span>.</span>
                                        <span>.</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        @if ($paginator->lastPage() - $paginator->currentPage() >= 2)
                            <a class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300"
                                @click="scrollToHead(); $wire.nextPage()" rel="next">
                                <x-heroicon-o-chevron-right class="h-4 w-4" />
                            </a>
                        @endif
                        <a class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300"
                            @click="scrollToHead(); $wire.gotoPage({{ $paginator->lastPage() }})">
                            <x-heroicon-o-chevron-double-right class="h-4 w-4" />
                        </a>
                    @endif
                </div>
            </nav>
        @endif

        <div>
            @if ($paginator->hasPages() && $recordCount == 'min')
                <nav role="navigation" aria-label="Pagination Navigation" class="items-center justify-between sm:flex">
                    <div class="flex justify-center mt-2 md:flex-none md:justify-end sm:mt-0">
                        <span>
                            {{-- Previous Page Link Disabled --}}
                            @if ($paginator->onFirstPage())
                                <button disabled
                                    class="p-2 m-1 text-center text-pg-primary-400 bg-pg-primary-200 rounded border-1 dark:text-pg-primary-300">
                                    <x-heroicon-o-chevron-double-left class="h-4 w-4" />
                                </button>
                            @else
                                @if (method_exists($paginator, 'getCursorName'))
                                    <button
                                        @click="scrollToHead(); $wire.setPage('{{ $paginator->previousCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
                                        wire:loading.attr="disabled"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <x-heroicon-o-chevron-double-left class="h-4 w-4" />
                                    </button>
                                @else
                                    <button @click="scrollToHead(); $wire.previousPage()('{{ $paginator->getPageName() }}')"
                                        wire:loading.attr="disabled"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <x-heroicon-o-chevron-double-left class="h-4 w-4" />
                                    </button>
                                @endif
                            @endif
                        </span>

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                @if (method_exists($paginator, 'getCursorName'))
                                    <button
                                        @click="scrollToHead(); $wire.setPage('{{ $paginator->nextCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
                                        wire:loading.attr="disabled"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <x-heroicon-o-chevron-double-right class="h-4 w-4" />
                                    </button>
                                @else
                                    <button @click="scrollToHead(); $wire.nextPage()('{{ $paginator->getPageName() }}')"
                                        wire:loading.attr="disabled"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <x-heroicon-o-chevron-double-right class="h-4 w-4" />
                                    </button>
                                @endif
                            @else
                                <button disabled
                                    class="p-2 m-1 text-center text-pg-primary-400 bg-pg-primary-200 rounded border-1 dark:text-pg-primary-300">
                                    <x-heroicon-o-chevron-double-right class="h-4 w-4" />
                                </button>
                            @endif
                        </span>
                    </div>
                </nav>
            @endif
        </div>
    </div>
</div>
