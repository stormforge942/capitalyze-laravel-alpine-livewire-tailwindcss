<div class="bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <div class="py-2 text-gray-700 dark:text-gray-200">
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
