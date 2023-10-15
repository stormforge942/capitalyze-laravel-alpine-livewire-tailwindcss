<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100">
    <div class="max-w-5xl px-3 mx-auto py-5" id="navigation">
        <div class="flex gap-10 justify-between">
            <div class="flex justify-self-stretch">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" class="h-8 w-auto" alt="Capitalyze Logo">
                    </a>
                </div>
            </div>

            <div class="h-12 flex-1  rounded-lg border border-gray-300 bg-white leading-[3rem] px-3 flex items-center">
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

        </div>
    </div>
</nav>
