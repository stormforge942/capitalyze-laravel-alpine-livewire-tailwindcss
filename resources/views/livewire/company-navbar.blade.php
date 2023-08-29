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
         @foreach ($navbarItems as $navbar)
            @if ($navbar->name === 'Earnings Calendar')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin'))
                  <li>
                     <x-jet-nav-link href="{{ route('earnings-calendar') }}" :active="request()->routeIs('earnings-calendar')">
                        {{ __('Earnings Calendar') }}
                     </x-jet-nav-link>
                  </li>
               @endif
            @endif
            @if ($navbar->name === 'Economics Calendar')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('economics-calendar') }}" :active="request()->routeIs('economics-calendar')">
                     {{ __('Economics Calendar') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Company Filings')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('company-filings') }}" :active="request()->routeIs('company-filings')">
                     {{ __('Company Filings') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Funds Filings')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('fund-filings') }}" :active="request()->routeIs('fund-filings')">
                     {{ __('Funds Filings') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Mutual Funds Filings')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('mutual-fund-filings') }}" :active="request()->routeIs('mutual-fund-filings')">
                     {{ __('Mutual Funds Filings') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Company Identifiers')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('company-identifiers') }}" :active="request()->routeIs('company-identifiers')">
                     {{ __('Company Identifiers') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Delistings')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('delistings') }}" :active="request()->routeIs('delistings')">
                     {{ __('Delistings') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Euronext')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('euronexts') }}" :active="request()->routeIs('euronexts')">
                     {{ __('Euronext') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Shanghai')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('shanghais') }}" :active="request()->routeIs('shanghais')">
                     {{ __('Shanghai') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'LSE')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('lses') }}" :active="request()->routeIs('lses')">
                     {{ __('LSE') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'TSX')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('tsxs') }}" :active="request()->routeIs('tsxs')">
                  {{ __('TSX') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Japan')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('japans') }}" :active="request()->routeIs('japans')">
                     {{ __('Japan') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
               @if ($navbar->name === 'HKEX')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('hkexs') }}" :active="request()->routeIs('hkexs')">
                  {{ __('HKEX') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
               @if ($navbar->name === 'Press Release')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <x-jet-nav-link href="{{ route('press.release') }}" :active="request()->routeIs('press.release')">
                     {{ __('Press Release') }}
                  </x-jet-nav-link>
               </li>
               @endif
            @endif
         @endforeach
      </ul>
      <hr class="my-4"> <!-- Separator -->
      <ul class="space-y-2 font-medium">

         <li>
         @if(!(in_array($currentRoute, ['company.shareholders', 'company.summary', 'company.insider', 'company.filings', 'company.restatement', 'company.employee'])))
            <!-- Settings Dropdown -->
            <div class="relative ml-3">
               <button wire:key="navbar-period-annual" class="@if($period == 'annual')text-blue-700 @else text-slate-700 pl-0 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500 pl-0" wire:click="changePeriod('annual')">Annual</button>
               <span class="text-indigo-600">|</span>
               <button wire:key="navbar-period-quarterly" class="@if($period == 'quarterly')text-blue-700 @else text-slate-700 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500" wire:click="changePeriod('quarterly')">Quarterly</button>
            </div>
            @endif
         </li>
         @foreach ($navbarItems as $navbar)
            @if ($navbar->name === 'Products')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-product-{{ $period }}"
                  href="/company/{{ $company->ticker }}/?period={{ $period }}" name="Products"
                  :active="$currentRoute === 'company.product'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Company Profile')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-profile-{{ $period }}"
                  href="/company/{{ $company->ticker }}/profile" name="Company Profile"
                  :active="$currentRoute === 'company.profile'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Geographic')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-geographic-{{ $period }}"
                  href="/company/{{ $company->ticker }}/geographic?period={{ $period }}" name="Geographic"
                  :active="$currentRoute === 'company.geographic'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Metrics')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-metrics-{{ $period }}"
                     href="/company/{{ $company->ticker }}/metrics?period={{ $period }}" name="Metrics"
                     :active="$currentRoute === 'company.metrics'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Full Report')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-report-{{ $period }}"
                     href="/company/{{ $company->ticker }}/report?period={{ $period }}" name="Full Report"
                     :active="$currentRoute === 'company.report'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Shareholders')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-shareholders"
                     href="/company/{{ $company->ticker }}/shareholders" name="Shareholders"
                     :active="$currentRoute === 'company.shareholders'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Summary')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-summary"
                     href="/company/{{ $company->ticker }}/summary" name="Summary"
                     :active="$currentRoute === 'company.summary'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Insider')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-summary"
                     href="/company/{{ $company->ticker }}/insider" name="Insider"
                     :active="$currentRoute === 'company.insider'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Filings')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-filings"
                     href="/company/{{ $company->ticker }}/filings" name="Filings"
                     :active="$currentRoute === 'company.filings'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Splits')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-splits"
                     href="/company/{{ $company->ticker }}/splits" name="Splits"
                     :active="$currentRoute === 'company.splits'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Chart')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-chart"
                     href="/company/{{ $company->ticker }}/chart" name="Chart"
                     :active="$currentRoute === 'company.chart'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Executive Compensation')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-chart"
                     href="/company/{{ $company->ticker }}/executive-compensation" name="Executive Compensation"
                     :active="$currentRoute === 'company.executive.compensation'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Restatement')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-insider"
                     href="/company/{{ $company->ticker }}/restatement" name="Restatement"
                     :active="$currentRoute === 'company.restatement'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Employee Count')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-employee"
                     href="/company/{{ $company->ticker }}/employee" name="Employee Count"
                     :active="$currentRoute === 'company.employee'" />
               </li>
               @endif
            @endif
            @if ($navbar->name === 'Fail To Deliver')
               @if ($navbar->show_admins && (Auth::user()->group === 'admin') || $navbar->show_users && (Auth::user()->group === 'user') || $navbar->show_testers && (Auth::user()->group === 'tester') || $navbar->show_developers && (Auth::user()->group === 'developer'))
               <li>
                  <livewire:company-navbar-item wire:key="navbar-employee"
                     href="/company/{{ $company->ticker }}/fail-to-deliver" name="Fail To Deliver"
                     :active="$currentRoute === 'company.fail.to.deliver'" />
               </li>
               @endif
            @endif
         @endforeach
      </ul>

   </div>
</aside>


</div>


</div>
