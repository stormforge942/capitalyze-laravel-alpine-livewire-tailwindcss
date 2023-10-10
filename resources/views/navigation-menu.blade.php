<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-4 sm:ml-64 pt-10 transition-all" id="navigation">
        <div class="flex justify-between h-16">

            @if (Request::is('/'))
                <div class="flex justify-self-stretch">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/capitalyze-logo.png') }}" class="block h-20 w-auto p-3"
                                alt="Capitalyze Logo">
                        </a>
                    </div>
                </div>
            @endif

            <div class="h-12 w-2/3 rounded-lg border border-gray-300 bg-white leading-[3rem] px-3 flex items-center">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.3645 14.3208H15.5515L15.2633 14.0429C16.2719 12.8696 16.8791 11.3465 16.8791 9.68954C16.8791 5.99485 13.8842 3 10.1895 3C6.49485 3 3.5 5.99485 3.5 9.68954C3.5 13.3842 6.49485 16.3791 10.1895 16.3791C11.8465 16.3791 13.3696 15.7719 14.5429 14.7633L14.8208 15.0515V15.8645L19.9666 21L21.5 19.4666L16.3645 14.3208ZM10.1895 14.3208C7.62693 14.3208 5.55832 12.2521 5.55832 9.68954C5.55832 7.12693 7.62693 5.05832 10.1895 5.05832C12.7521 5.05832 14.8208 7.12693 14.8208 9.68954C14.8208 12.2521 12.7521 14.3208 10.1895 14.3208Z"
                        fill="#9DA3A8" />
                </svg>

                <button wire:click="$emit('spotlight.toggle')" class="w-full text-left text-[#7C8286] text-sm ml-3">
                    {{ __('Search Stocks, Tickers ...') }}
                </button>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="sm:hidden flex justify-center justify-items-stretch m-auto flex-grow h-12">
            <button wire:click="$emit('spotlight.toggle')" class="h-8 w-full grid grid-cols-5 mx-auto max-w-md">
                <span
                    class="border-2 border-gray-200 border-r-0 text-sm font-medium leading-5 text-gray-500 justify-self-stretch col-span-4 text-left h-8 px-2 py-1">
                    {{ __('Search Stocks, Tickers ...') }}
                </span>
                <div class="bg-blue-500 h-8 px-2 py-1 text-center flex flex-row">
                    <svg class="h-5 w-5 text-md font-medium leading-5 text-white m-auto" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </button>
        </div>
    </div>
</nav>
