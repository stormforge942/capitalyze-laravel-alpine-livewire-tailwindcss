<div>
   <div>
        <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
        </button>

        <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/capitalyze-logo-bg.png') }}" class="block h-20 w-auto p-3" alt="Capitalyze Logo">
            </a>
            <ul class="space-y-2 font-medium">
                <li>
                    <x-jet-nav-link href="{{ route('earnings-calendar') }}" :active="request()->routeIs('earnings-calendar')">
                    {{ __('Earnings Calendar') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('economics-calendar') }}" :active="request()->routeIs('economics-calendar')">
                    {{ __('Economics Calendar') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('company-filings') }}" :active="request()->routeIs('company-filings')">
                    {{ __('Company Filings') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('fund-filings') }}" :active="request()->routeIs('fund-filings')">
                    {{ __('Funds Filings') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('mutual-fund-filings') }}" :active="request()->routeIs('mutual-fund-filings')">
                    {{ __('Mutual Funds Filings') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('company-identifiers') }}" :active="request()->routeIs('company-identifiers')">
                    {{ __('Company Identifiers') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('delistings') }}" :active="request()->routeIs('delistings')">
                    {{ __('Delistings') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('euronexts') }}" :active="request()->routeIs('euronexts')">
                    {{ __('Euronext') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('shanghais') }}" :active="request()->routeIs('shanghais')">
                    {{ __('Shanghai') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('lses') }}" :active="request()->routeIs('lses')">
                    {{ __('LSE') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('japans') }}" :active="request()->routeIs('japans')">
                    {{ __('Japan') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('hkexs') }}" :active="request()->routeIs('hkexs')">
                    {{ __('HKEX') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('press.release') }}" :active="request()->routeIs('press.release')">
                    {{ __('Press Release') }}
                    </x-jet-nav-link>
                </li>
            </ul>
            <hr class="my-4"> <!-- Separator -->
            <ul class="space-y-2 font-medium">
                <li>
                    <x-jet-nav-link href="{{ route('mutual-fund.holdings', ['cik' => $fund->cik, 'fund_symbol' => $fund->fund_symbol, 'series_id' => $fund->series_id, 'class_id' => $fund->class_id]) }}" :active="request()->routeIs('mutual-fund.holdings')">
                    {{ __('Holdings') }}
                    </x-jet-nav-link>
                </li>
                <li>
                    <x-jet-nav-link href="{{ route('mutual-fund.returns', ['cik' => $fund->cik, 'fund_symbol' => $fund->fund_symbol, 'series_id' => $fund->series_id, 'class_id' => $fund->class_id]) }}" :active="request()->routeIs('mutual-fund.returns')">
                    {{ __('Returns') }}
                    </x-jet-nav-link>
                </li>
            </ul>
        </div>
        </aside>
    </div>
</div>