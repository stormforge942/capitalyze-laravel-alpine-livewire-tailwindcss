<div class="lg:ml-64" id="navigation">
    <div class="flex items-center justify-between px-4 py-8 bg-white lg:hidden">
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
                <img src="/img/logo.png" alt="Capitalyze logo" class="w-auto h-6">
            </a>
        </div>

        <div>
            @auth
                <button id="profileButtonMobile" data-dropdown-toggle="dropdownProfileMobile" type="button"
                    class="bg-[#52D3A2] w-9 h-9 leading-9 rounded-full font-semibold text-[14px] focus:outline-none transition self-start">
                    {{ Auth::user()->initials }}
                </button>

                <div id="dropdownProfileMobile"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <div class="py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownTopButton">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Account') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-jet-dropdown-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                        @endif

                        @if (Auth::user() && Auth::user()->isAdmin())
                            <x-jet-dropdown-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                                {{ __('User Management') }}
                            </x-jet-dropdown-link>
                        @endif

                        @if (Auth::user() && Auth::user()->isAdmin() && Route::has('admin.navbar-management'))
                            <x-jet-dropdown-link href="{{ route('admin.navbar-management') }}" :active="request()->routeIs('admin.navbar-management')">
                                {{ __('Users Permissions') }}
                            </x-jet-dropdown-link>
                        @endif

                        @if (Auth::user() && Auth::user()->isAdmin())
                            <x-jet-dropdown-link href="{{ route('admin.groups-management') }}" :active="request()->routeIs('admin.groups-management')">
                                {{ __('Groups Management') }}
                            </x-jet-dropdown-link>
                        @endif

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <button type="submit" class="flex items-center p-2">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_872_3965)">
                                        <path
                                            d="M11.804 5.13712C11.5441 4.8773 11.1229 4.8773 10.863 5.13712C10.6036 5.39659 10.6032 5.81715 10.8621 6.07712L12.1135 7.33333H6.00016C5.63197 7.33333 5.3335 7.63181 5.3335 8C5.3335 8.36819 5.63197 8.66667 6.00016 8.66667H12.1135L10.8635 9.91666C10.6037 10.1765 10.6029 10.5976 10.8618 10.8583C11.1221 11.1204 11.5457 11.1211 11.8068 10.86L14.6668 8L11.804 5.13712ZM2.66683 3.33333H7.3335C7.70169 3.33333 8.00016 3.03486 8.00016 2.66667C8.00016 2.29848 7.70169 2 7.3335 2H2.66683C1.9335 2 1.3335 2.6 1.3335 3.33333V12.6667C1.3335 13.4 1.9335 14 2.66683 14H7.3335C7.70169 14 8.00016 13.7015 8.00016 13.3333C8.00016 12.9651 7.70169 12.6667 7.3335 12.6667H2.66683V3.33333Z"
                                            fill="#E30004" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_872_3965">
                                            <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                                <span class="ml-3 text-[#E30004]">{{ __('Log Out') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <div class="px-4 pt-4 pb-6 transition-all md:px-6 lg:px-8 lg:pt-8 lg:max-w-7xl">
        <div
            class="h-14 w-full lg:w-2/3 rounded-lg border border-gray-300 bg-white leading-[3rem] px-3 flex items-center">
            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.3645 14.3208H15.5515L15.2633 14.0429C16.2719 12.8696 16.8791 11.3465 16.8791 9.68954C16.8791 5.99485 13.8842 3 10.1895 3C6.49485 3 3.5 5.99485 3.5 9.68954C3.5 13.3842 6.49485 16.3791 10.1895 16.3791C11.8465 16.3791 13.3696 15.7719 14.5429 14.7633L14.8208 15.0515V15.8645L19.9666 21L21.5 19.4666L16.3645 14.3208ZM10.1895 14.3208C7.62693 14.3208 5.55832 12.2521 5.55832 9.68954C5.55832 7.12693 7.62693 5.05832 10.1895 5.05832C12.7521 5.05832 14.8208 7.12693 14.8208 9.68954C14.8208 12.2521 12.7521 14.3208 10.1895 14.3208Z"
                    fill="#9DA3A8" />
            </svg>

            <button wire:click="$emit('spotlight.toggle')" class="w-full text-left text-[#7C8286] text-sm ml-3">
                Search
            </button>
        </div>
    </div>
</div>
