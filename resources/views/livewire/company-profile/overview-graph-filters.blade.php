<div class="px-1 flex items-center gap-x-8 text-gray-medium2">
    <div class="flex items-center gap-5 text-sm">
        <?php
        $ranges = ['3m' => '3m', '6m' => '6m', 'YTD' => 'YTD', '1yr' => '1yr', '5yr' => '5yr', 'max' => 'MAX'];
        ?>
        @foreach ($ranges as $value => $label)
            <label class="flex items-center gap-x-1 {{ $currentChartPeriod === $value ? 'text-dark' : '' }}">
                <input wire:model="currentChartPeriod" value="{{ $value }}" type="radio" name="date-range" class="h-4 w-4 checked:text-dark peer outline-dark">
                <span class="peer-checked:text-dark">{{ $label }}</span>
            </label>
        @endforeach
    </div>

    <livewire:range-calendar />

    {{--  <div x-show="showgraph"
        :class="{ 'custom-dropdown-absolute-wrapper': !showgraph, 'custom-dropdown-absolute-wrapper abs-custom': showgraph }">
        <div class="relative custom-dropdown-absolute-wrapper-inner flex justify-end" x-data="{
            chartMenuOpen: false
        }">
            <div>
                <button type="button" @click="chartMenuOpen = !chartMenuOpen" class="custom-drop-down-button hide-mobile"
                    id="menu-button" aria-expanded="true" aria-haspopup="true">

                    <svg x-show="!chartMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="#121A0F" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                    </svg>

                    <svg x-show="chartMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="#121A0F" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>

                </button>
            </div>
            
            <div @click.away="chartMenuOpen = false" x-show="chartMenuOpen"
                class="absolute custom-drop-down right-0 z-10    bg-white  focus:outline-none" role="menu"
                aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <div class="links-wrapper mb-3">
                        <a href="#" x-show="showgraph"
                            @click="showgraph = !showgraph; chartMenuOpen =! chartMenuOpen;" class="menu_link"
                            role="menuitem" tabindex="-1" id="menu-item-0">Hide Chart</a>
                        <a href="#" x-show="!showgraph" @click="showgraph = !showgraph" class="menu_link"
                            role="menuitem" tabindex="-1" id="menu-item-0">Show Chart</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-1">View In Full
                            Screen</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-2">Print
                            Chart</a>
                    </div>
                    <hr class="mb-3">
                    <div class="links-wrapper">
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-3"> <svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download As PNG</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-4"> <svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download As PNG</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-5"> <svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download As PNG</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{--             <div>
                <div class="relative custom-dropdown-absolute-wrapper-inner mobile-show flex justify-end"
                    x-data="{
                        openMobileGraph: false
                    }">
                    <div>
                        <button type="button" @click="openMobileGraph = !openMobileGraph"
                            class="custom-drop-down-button-lg" id="menu-button" aria-expanded="true"
                            aria-haspopup="true">
                            Select
                            <svg x-show="!openMobileGraph" xmlns="http://www.w3.org/2000/svg" fill="#121A0F"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>



                            <svg x-show="openMobileGraph" xmlns="http://www.w3.org/2000/svg" fill="#121A0F"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            </svg>


                        </button>
                    </div>


                    <div @click.away="openMobileGraph = false" x-show="openMobileGraph"
                        class="absolute custom-drop-down right-0 z-10    bg-white  focus:outline-none" role="menu"
                        aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                            <div class="links-wrapper mb-3">

                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-1">View
                                    In Full Screen</a>
                                <a href="#" class="menu_link" role="menuitem" tabindex="-1"
                                    id="menu-item-2">Print Chart</a>
                            </div>
                            <hr class="mb-3">
                            <div class="links-wrapper">
                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    Download As PNG</a>
                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    Download As PNG</a>
                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    Download As PNG</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
</div>
