<x-breadcrumb :items="[
    [
        'text' => 'Ownership',
    ],
    [
        'text' => 'Shareholders',
        'href' => $initialUrl ?? '#',
    ],
]">
    <div class="ml-2 items-center hidden gap-6 xl:flex text-[#7C8286]">
        @foreach (array_slice($historyItems, 0, 3) as $item)
            <div class="flex items-center gap-2">
                <a href="{{ $item['url'] }}"
                    class="hover:text-dark-light2 whitespace-nowrap @if ($item['active']) text-blue ownership-active-bread-link @endif">{{ $item['name'] }}
                </a>

                <button class="h-4 w-4" wire:click="removeHistory('{{ $item['url'] }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path
                            d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
        @endforeach

        @if (count($historyItems) > 3)
            <div x-data="{ dropdown: null }" x-init="dropdown = new Dropdown($refs.dropdown, $refs.button)">
                <button class="flex items-center gap-2" x-ref="button">
                    <span class="hover:text-dark-light2">More</span>
                    <span
                        class="shrink-0 flex items-center justify-center w-4 h-4 text-xs text-white rounded-full bg-blue">{{ count($historyItems) - 3 }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#464E49" />
                    </svg>
                </button>

                <div class="hidden w-64 px-4 py-4 bg-white divide-y rounded shadow" x-ref="dropdown">
                    @foreach (array_slice($historyItems, 3) as $item)
                        <div class="flex items-center justify-between gap-2 py-2 first:pt-0 last:pb-0">
                            <a href="{{ $item['url'] }}"
                                class="@if ($item['active']) text-blue @else hover:text-dark-light2 @endif">
                                {{ $item['name'] }}
                            </a>

                            <button wire:click="removeHistory('{{ $item['url'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                    viewBox="0 0 10 10" fill="none">
                                    <path
                                        d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                                        fill="#C22929" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if (count($historyItems))
            <button class="whitespace-nowrap font-semibold lg:block text-red" wire:click="clearHistory">
                Clear All
            </button>
        @endif
    </div>

    <div class="ml-2 items-center hidden gap-6 md:flex xl:hidden text-[#7C8286]">
        @foreach (array_slice($historyItems, 0, 2) as $item)
            <div class="flex items-center gap-2">
                <a href="{{ $item['url'] }}"
                    class="hover:text-dark-light2 whitespace-nowrap @if ($item['active']) text-blue ownership-active-bread-link @endif">{{ $item['name'] }}
                </a>

                <button class="h-4 w-4" wire:click="removeHistory('{{ $item['url'] }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path
                            d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
        @endforeach

        @if (count($historyItems) > 2)
            <div x-data="{ dropdown: null }" x-init="dropdown = new Dropdown($refs.dropdown, $refs.button)">
                <button class="flex items-center gap-2" x-ref="button">
                    <span class="hover:text-dark-light2">More</span>
                    <span
                        class="shrink-0 flex items-center justify-center w-4 h-4 text-xs text-white rounded-full bg-blue">{{ count($historyItems) - 2 }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#464E49" />
                    </svg>
                </button>

                <div class="hidden w-64 px-4 py-4 bg-white divide-y rounded shadow" x-ref="dropdown">
                    @foreach (array_slice($historyItems, 2) as $item)
                        <div class="flex items-center justify-between gap-2 py-2 first:pt-0 last:pb-0">
                            <a href="{{ $item['url'] }}"
                                class="@if ($item['active']) text-blue @else hover:text-dark-light2 @endif">
                                {{ $item['name'] }}
                            </a>

                            <button wire:click="removeHistory('{{ $item['url'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                    viewBox="0 0 10 10" fill="none">
                                    <path
                                        d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                                        fill="#C22929" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if (count($historyItems))
            <button class="whitespace-nowrap font-semibold lg:block text-red" wire:click="clearHistory">
                Clear All
            </button>
        @endif
    </div>

    <div class="ml-2 items-center gap-4 hidden sm:flex md:hidden text-[#7C8286]">
        @foreach (array_slice($historyItems, 0, 1) as $item)
            <div class="flex items-center gap-2">
                <a href="{{ $item['url'] }}"
                    class="hover:text-dark-light2 whitespace-nowrap @if ($item['active']) text-blue ownership-active-bread-link @endif">{{ $item['name'] }}
                </a>

                <button wire:click="removeHistory('{{ $item['url'] }}', '{{ $item['type'] }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"
                        fill="none">
                        <path
                            d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
        @endforeach

        @if (count($historyItems) > 1)
            <div x-data="{ dropdown: null }" x-init="dropdown = new Dropdown($refs.dropdown, $refs.button)">
                <button class="flex items-center gap-2" x-ref="button">
                    <span class="hover:text-dark-light2">More</span>
                    <span
                        class="shrink-0 flex items-center justify-center w-4 h-4 text-xs text-white rounded-full bg-blue">{{ count($historyItems) - 1 }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#464E49" />
                    </svg>
                </button>

                <div class="hidden w-64 px-4 py-4 bg-white divide-y rounded shadow" x-ref="dropdown">
                    @foreach (array_slice($historyItems, 1) as $item)
                        <div class="flex items-center justify-between gap-2 py-2 first:pt-0 last:pb-0">
                            <a href="{{ $item['url'] }}"
                                class="@if ($item['active']) text-blue @else hover:text-dark-light2 @endif">
                                {{ $item['name'] }}
                            </a>

                            <button wire:click="removeHistory('{{ $item['url'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                    viewBox="0 0 10 10" fill="none">
                                    <path
                                        d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                                        fill="#C22929" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="ml-2 items-center gap-4 flex sm:hidden text-[#7C8286]">
        @if (count($historyItems))
            <div x-data="{ dropdown: null }" x-init="dropdown = new Dropdown($refs.dropdown, $refs.button)">
                <button class="flex items-center gap-2" x-ref="button">
                    <span class="hover:text-dark-light2">{{ $historyItems[0]['name'] }}</span>

                    <span
                        class="shrink-0 flex items-center justify-center w-4 h-4 text-xs text-white rounded-full bg-blue">{{ count($historyItems) - 1 }}</span>
                        
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#464E49" />
                    </svg>
                </button>

                <div class="hidden w-64 px-4 py-4 bg-white divide-y rounded shadow" x-ref="dropdown">
                    @foreach (array_slice($historyItems, 1) as $item)
                        <div class="flex items-center justify-between gap-2 py-2 first:pt-0 last:pb-0">
                            <a href="{{ $item['url'] }}"
                                class="@if ($item['active']) text-blue @else hover:text-dark-light2 @endif">
                                {{ $item['name'] }}
                            </a>

                            <button wire:click="removeHistory('{{ $item['url'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                    viewBox="0 0 10 10" fill="none">
                                    <path
                                        d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                                        fill="#C22929" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-breadcrumb>
