<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-4 sm:ml-64">
        <div class="flex justify-between h-16">

            @if(Request::is('/'))
            <div class="flex justify-self-stretch">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                    <img src="{{ asset('img/capitalyze-logo.png') }}" class="block h-20 w-auto p-3" alt="Capitalyze Logo">
                    </a>
                </div>
            </div>
            @endif
            
            <div class="hidden sm:flex justify-center justify-items-stretch m-auto flex-grow px-10">
                <button wire:click="$emit('spotlight.toggle')" class="h-10 w-full grid grid-cols-5 mx-auto max-w-lg">
                    <span class="border-2 border-gray-200 border-r-0 text-sm font-medium leading-7 text-gray-500 justify-self-stretch col-span-4 text-left h-10 px-2 py-1">
                        {{ __('Search Stocks, Tickers ...') }}
                    </span>
                    <div class="bg-blue-500 h-10 px-2 py-1 text-center flex flex-row">
                        <svg class="h-5 w-5 text-md font-medium leading-5 text-white m-auto" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </button>
            </div>


            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                @if(Auth::user())
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                                @endif
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
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

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="sm:hidden flex justify-center justify-items-stretch m-auto flex-grow h-12">
                <button wire:click="$emit('spotlight.toggle')" class="h-8 w-full grid grid-cols-5 mx-auto max-w-md">
                    <span class="border-2 border-gray-200 border-r-0 text-sm font-medium leading-5 text-gray-500 justify-self-stretch col-span-4 text-left h-8 px-2 py-1">
                    {{ __('Search Stocks, Tickers ...') }}
                    </span>
                    <div class="bg-blue-500 h-8 px-2 py-1 text-center flex flex-row">
                        <svg class="h-5 w-5 text-md font-medium leading-5 text-white m-auto" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </button>
            </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                 <x-jet-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('earnings-calendar') }}" :active="request()->routeIs('earnings-calendar')">
                        {{ __('Earnings Calendar') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('company-filings') }}" :active="request()->routeIs('company-filings')">
                        {{ __('Company Filings') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('fund-filings') }}" :active="request()->routeIs('fund-filings')">
                        {{ __('Funds Filings') }}
                    </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Login') }}
                </x-jet-responsive-nav-link>
    </div>
</nav>
