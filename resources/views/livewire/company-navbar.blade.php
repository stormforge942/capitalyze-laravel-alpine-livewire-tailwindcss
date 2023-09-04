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
               @if ($navbar->is_moddable && $this->showNavbar($navbar->id) && !Str::startsWith($navbar->route_name, ['company.', 'lse.', 'tsx.', 'fund.', 'mutual-fund.', 'shanghai.', 'japan.', 'hkex.', 'euronext']))
                  <li>
                     <x-jet-nav-link href="{{ route($navbar->route_name) }}" :active="request()->routeIs($navbar->route_name)">
                        {{ __($navbar->name) }}
                     </x-jet-nav-link>
                  </li>
               @endif
            @endforeach
         </ul>
         <hr class="my-4"> <!-- Separator -->
         <ul class="space-y-2 font-medium">
            <li>
            @if(in_array($currentRoute, ['company.shareholders', 'company.summary', 'company.insider', 'company.filings', 'company.restatement', 'company.employee']))
               <!-- Settings Dropdown -->
               <div class="relative ml-3">
                  <button wire:key="navbar-period-annual" class="@if($period == 'annual')text-blue-700 @else text-slate-700 pl-0 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500 pl-0" wire:click="changePeriod('annual')">Annual</button>
                  <span class="text-indigo-600">|</span>
                  <button wire:key="navbar-period-quarterly" class="@if($period == 'quarterly')text-blue-700 @else text-slate-700 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500" wire:click="changePeriod('quarterly')">Quarterly</button>
               </div>
            @endif
            </li>
            @foreach ($navbarItems as $navbar)
               @if ($navbar->is_moddable && $this->showNavbar($navbar->id) && Str::startsWith($navbar->route_name, ['company.']))
                  <li>
                     <livewire:company-navbar-item wire:key="{{ $navbar->route_name }}-{{ $period }}"
                     href="{{ route($navbar->route_name, ['ticker' => $company->ticker, 'period' => $period]) }}" name="{{ $navbar->name }}"
                     :active="$currentRoute === $navbar->route_name" />
                  </li>
               @endif
            @endforeach
         </ul>
      </div>
   </aside>
</div>
