<x-guest-layout>
    <div>
        <main class="">
        <header class="bg-white shadow">
  <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
    <nav class="hidden lg:flex lg:py-2" aria-label="Global">
      <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
    <div class="lg:space-x-4">
      <a href="#" class="bg-gray-100 text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Geographic</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Product</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Metrics</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">c/ Calcbench</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Full report</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">F.R. by period</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Harmonization Sc2</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Harmonization Sc3</a>
    </div>
      <div class="hidden sm:flex sm:items-center ml-auto">

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <label for="period" class="inline-flex text-gray-900 text-sm font-medium"> Periodicity : </label>
                    <select wire:model.lazy="period"
                            class="inline-flex appearance-none bg-slate-50 border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500  dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500" name="period" id="period">
                            <option value="annual">
                                Annual
                            </option>
                            <option value="quarterly">
                                Quarterly
                            </option>
                    </select>
                </div>
            </div>
    </nav>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <nav class="lg:hidden" aria-label="Global" id="mobile-menu">
    <div class="space-y-1 px-2 pt-2 pb-3">
      <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
      <a href="#" class="bg-gray-100 text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Geographic</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Product</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Metrics</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">c/ Calcbench</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Full report</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">F.R. by period</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Harmonization Sc2</a>

      <a href="#" class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Harmonization Sc3</a>
    </div>
  </nav>
</header>
   
  </main>
    </div>
</x-guest-layout>