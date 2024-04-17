<div class="lg:ml-56" id="navigation">
    <div class="flex items-center justify-between px-4 md:px-6 py-8 bg-white lg:hidden header__main">
        <div class="flex items-center justify-between gap-1">
            @auth
                <button class="p-1" x-data @click="$dispatch('toggle-mobile-nav')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.3333 11H4.66667C4.26667 11 4 11.2667 4 11.6667V13C4 13.4 4.26667 13.6667 4.66667 13.6667H19.3333C19.7333 13.6667 20 13.4 20 13V11.6667C20 11.2667 19.7333 11 19.3333 11Z"
                            fill="#121A0F" />
                        <path
                            d="M19.3333 5.3335H4.66667C4.26667 5.3335 4 5.60016 4 6.00016V7.3335C4 7.7335 4.26667 8.00016 4.66667 8.00016H19.3333C19.7333 8.00016 20 7.7335 20 7.3335V6.00016C20 5.60016 19.7333 5.3335 19.3333 5.3335Z"
                            fill="#121A0F" />
                        <path
                            d="M19.3333 16.667H4.66667C4.26667 16.667 4 16.9337 4 17.3337V18.667C4 19.067 4.26667 19.3337 4.66667 19.3337H19.3333C19.7333 19.3337 20 19.067 20 18.667V17.3337C20 16.9337 19.7333 16.667 19.3333 16.667Z"
                            fill="#121A0F" />
                    </svg>
                </button>
            @endauth
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Capitalyze logo" class="w-auto h-6">
            </a>
        </div>

        <div>
            @auth
                <button id="profileButtonMobile" data-dropdown-toggle="dropdownProfileMobile" type="button"
                    class="bg-[#52D3A2] w-9 h-9 leading-9 rounded-full font-semibold focus:outline-none transition self-start">
                    {{ Auth::user()->initials }}
                </button>

                <div id="dropdownProfileMobile" class="z-10 hidden pr-4" aria-labelledby="profileButtonMobile">
                    @include('partials.profile-dropdown')
                </div>
            @endauth
        </div>
    </div>

    <div class="px-4 pt-4 pb-6 md:px-6 lg:px-8 lg:pt-8" >
        <div class="flex items-center justify-between gap-x-2 mx-auto" style="max-width: 1500px;">
            <div class="flex-1 transition-all lg:max-w-7xl">
                <div
                    class="h-14 w-full lg:w-2/3 rounded-lg border border-gray-300 bg-white leading-[3rem] px-3 flex items-center focus-within:border-green-dark">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.3645 14.3208H15.5515L15.2633 14.0429C16.2719 12.8696 16.8791 11.3465 16.8791 9.68954C16.8791 5.99485 13.8842 3 10.1895 3C6.49485 3 3.5 5.99485 3.5 9.68954C3.5 13.3842 6.49485 16.3791 10.1895 16.3791C11.8465 16.3791 13.3696 15.7719 14.5429 14.7633L14.8208 15.0515V15.8645L19.9666 21L21.5 19.4666L16.3645 14.3208ZM10.1895 14.3208C7.62693 14.3208 5.55832 12.2521 5.55832 9.68954C5.55832 7.12693 7.62693 5.05832 10.1895 5.05832C12.7521 5.05832 14.8208 7.12693 14.8208 9.68954C14.8208 12.2521 12.7521 14.3208 10.1895 14.3208Z"
                            fill="#9DA3A8" />
                    </svg>
    
                    <button wire:click="$emit('spotlight.toggle')" class="w-full text-left text-[#7C8286] ml-3 focus:outline-none">
                        Search
                    </button>
                </div>
            </div>
    
            <button type="button" class="h-[50px] lg:h-auto bg-dark text-green-dark font-medium text-sm flex items-center gap-x-2 px-4 py-2 rounded hover:bg-opacity-80 transition-all" onclick="Livewire.emit('modal.open', 'rate-experience')">
                <span class="hidden sm:inline">Submit Feedback</span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.30564 12.6667L1.33594 15V2.66667C1.33594 2.29848 1.63442 2 2.0026 2H14.0026C14.3708 2 14.6693 2.29848 14.6693 2.66667V12C14.6693 12.3682 14.3708 12.6667 14.0026 12.6667H4.30564ZM7.33594 9.33333V10.6667H8.66927V9.33333H7.33594ZM5.71414 5.87564L7.0218 6.13718C7.113 5.67882 7.51747 5.33333 8.0026 5.33333C8.55487 5.33333 9.0026 5.78105 9.0026 6.33333C9.0026 6.8856 8.55487 7.33333 8.0026 7.33333H7.33594V8.66667H8.0026C9.29127 8.66667 10.3359 7.622 10.3359 6.33333C10.3359 5.04467 9.29127 4 8.0026 4C6.8706 4 5.92685 4.80613 5.71414 5.87564Z"
                        fill="#52D3A2" />
                </svg>
            </button>
        </div>
    </div>
</div>
