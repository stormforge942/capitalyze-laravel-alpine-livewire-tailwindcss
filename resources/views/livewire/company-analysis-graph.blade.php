<div class="main-graph-wrapper main-graph-rev w-full" x-show="showgraph">
    <div x-show="showgraph"
        :class="{ 'custom-dropdown-absolute-wrapper': !showgraph, 'custom-dropdown-absolute-wrapper abs-custom': showgraph }">
        <div class="relative custom-dropdown-absolute-wrapper-inner flex justify-end" x-data="{
            chartMenuOpen: false
        }">
            <div x-show="showgraph">
                <button type="button" @click="chartMenuOpen = !chartMenuOpen"
                    class="custom-drop-down-button hide-mobile" id="menu-button" aria-expanded="true"
                    aria-haspopup="true">

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
                        <a href="#" x-show="showgraph" @click="showgraph = !showgraph; chartMenuOpen = false"
                            class="menu_link" role="menuitem" tabindex="-1" id="menu-item-0">Hide Chart</a>
                        <a href="#" x-show="!showgraph" @click="showgraph = !showgraph; chartMenuOpen = false"
                            class="menu_link" role="menuitem" tabindex="-1" id="menu-item-0">Show Chart</a>
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
    </div>

    <div class="relative graph-wrapper-box w-full">
        <div class="graph-wrapper graph-wrapper-rev ">
            <div class="graph-header graph-header-flex relative mb-5">
                <div class="pr-3">
                    <p class="title revenue-title" wire:click="load()">{{ $name }}. ({{ $ticker }}) </p>
                    <p class="revenue-subtitle">Revenue by Product </p>
                </div>

                <div>
                    <div class="relative custom-dropdown-absolute-wrapper-inner mobile-show flex justify-end" x-data="{
                            openMobileGraph: false
                        }">
                        <div>
                            <button type="button" @click="openMobileGraph = !openMobileGraph"
                                class="custom-drop-down-button-lg" id="menu-button" aria-expanded="true"
                                aria-haspopup="true">
                                Select
                                <svg x-show="!openMobileGraph" xmlns="http://www.w3.org/2000/svg" fill="#121A0F"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>



                                <svg x-show="openMobileGraph" xmlns="http://www.w3.org/2000/svg" fill="#121A0F"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                </svg>


                            </button>
                        </div>


                        <div @click.away="openMobileGraph = false" x-show="openMobileGraph"
                            class="absolute custom-drop-down right-0 z-10    bg-white  focus:outline-none" role="menu"
                            aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                <div class="links-wrapper mb-3">

                                    <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-1">View In
                                        Full Screen</a>
                                    <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-2">Print
                                        Chart</a>
                                </div>
                                <hr class="mb-3">
                                <div class="links-wrapper">
                                    <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-3"> <svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download As PNG</a>
                                    <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-4"> <svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download As PNG</a>
                                    <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-5"> <svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download As PNG</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="select-graph-date-wrapper desktop-show ml-12 flex">
                    <ul class="items-center w-full flex custom_radio_wrapper">
                        <li class="">
                            <input value="Values" id="Values" type="radio" name="chart-type" name="radio-group" checked>
                            <label for="Values" onclick="typeChanged('values')">Values</label>
                        </li>
                        <li class="">
                            <input value="Percentage Mix" id="Percentage" type="radio" name="chart-type"
                                name="radio-group">
                            <label for="Percentage" onclick="typeChanged('percentage')">Percentage Mix</label>
                        </li>
                        <li class="custom_checkbox" x-data="{toggle: false, toggle2: false}">
                            <button
                                class="flex items-center transition ease-in-out duration-300 w-7 h-3 bg-gray-custom rounded-full focus:outline-none"
                                :class="{ 'bg-gray-custom': toggle2 }"
                                x-on:click="toggle2 = !toggle2; showLabels(toggle2)">
                                <div class="transition ease-in-out duration-300 rounded-full h-4 w-4 bg-white shadow border"
                                    :class="{ 'transform translate-x-full ': toggle2 }"></div>
                            </button> <span class="title">Show Labels</span>
                        </li>

                    </ul>

                </div>

            </div>
            {{-- <div class="place-items-center h-96" wire:loading.grid>
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
            --}}
            <div class="mt-3 mr-5" wire:loading.remove x-show="showgraph" x-transition>
                <canvas id="{{$chartId}}canvas" wire:ignore></canvas>
            </div>
            <div class="flex justify-end">
                <div class="mr-5 mt-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="65" height="16" viewBox="0 0 80 16" fill="none">
                        <path
                            d="M29.8334 5.61422C30.1938 6.30619 30.374 7.11691 30.374 8.04719C30.374 8.95371 30.1938 9.75297 29.8334 10.4449C29.473 11.1369 28.9726 11.6717 28.3329 12.0492C27.6932 12.4267 26.9666 12.6159 26.1524 12.6159C25.4898 12.6159 24.914 12.4938 24.4258 12.2498C23.9376 12.0058 23.5477 11.6741 23.257 11.2557V15.9996H21.373V3.58252L23.0129 3.58252L23.2398 4.90832C23.9606 3.95512 24.932 3.47852 26.1533 3.47852C26.9674 3.47852 27.694 3.66113 28.3337 4.028C28.9734 4.39487 29.473 4.92225 29.8334 5.61422ZM28.4549 8.04719C28.4549 7.16359 28.2133 6.44868 27.7308 5.90247C27.2484 5.35626 26.6177 5.08275 25.8379 5.08275C25.059 5.08275 24.4307 5.35299 23.954 5.89347C23.4773 6.43394 23.2389 7.14066 23.2389 8.01279C23.2389 8.90786 23.4773 9.63422 23.954 10.1927C24.4307 10.7504 25.059 11.0296 25.8379 11.0296C26.6169 11.0296 27.2476 10.7504 27.7308 10.1927C28.2141 9.63504 28.4549 8.91932 28.4549 8.04719Z"
                            fill="#121A0F" />
                        <path
                            d="M34.397 5.23794V3.5813H35.9492V1.08691L37.8503 1.08691V3.58048L39.9963 3.58048V5.23712H37.8503V9.89342C37.8503 10.2423 37.9199 10.4896 38.06 10.6345C38.1992 10.7795 38.4376 10.8524 38.775 10.8524H40.2052V12.509H38.3909C37.5423 12.509 36.9231 12.3116 36.5332 11.9161C36.1433 11.5206 35.9492 10.9105 35.9492 10.085V5.23794H34.397Z"
                            fill="#121A0F" />
                        <path d="M52.1954 0.302246V12.5105H50.3115V0.302246L52.1954 0.302246Z" fill="#121A0F" />
                        <path
                            d="M70.3949 3.58057V4.92357L65.4058 10.8533H70.621V12.5099L62.8765 12.5099V11.1669L67.8647 5.23721L63.0853 5.23721V3.58057L70.3949 3.58057Z"
                            fill="#121A0F" />
                        <path
                            d="M73.332 4.04178C73.9889 3.66345 74.7416 3.4751 75.591 3.4751C76.4519 3.4751 77.2104 3.64952 77.8673 3.99838C78.5242 4.34723 79.0419 4.84103 79.4195 5.4806C79.7979 6.12016 79.992 6.87028 80.0035 7.73013C80.0035 7.9627 79.9863 8.201 79.9511 8.44503H73.2181V8.54985C73.2648 9.32863 73.5089 9.94527 73.9504 10.3981C74.3919 10.8518 74.9792 11.0786 75.7123 11.0786C76.2938 11.0786 76.782 10.9419 77.1776 10.6684C77.5732 10.3948 77.8345 10.0083 77.9623 9.50879H79.8462C79.6832 10.4161 79.245 11.1597 78.5291 11.7411C77.8132 12.3225 76.9212 12.6133 75.8515 12.6133C74.921 12.6133 74.1101 12.4249 73.418 12.0466C72.7259 11.6682 72.191 11.1368 71.8134 10.4505C71.435 9.76429 71.2466 8.96831 71.2466 8.06178C71.2466 7.14297 71.4301 6.33799 71.7962 5.64601C72.164 4.95486 72.6751 4.42011 73.332 4.04178ZM77.3095 5.54201C76.8737 5.17596 76.3241 4.99253 75.6607 4.99253C75.0439 4.99253 74.5123 5.1817 74.0643 5.55921C73.617 5.93673 73.3574 6.43953 73.2878 7.06763L78.0852 7.06763C78.0041 6.4166 77.7453 5.90806 77.3095 5.54201Z"
                            fill="#121A0F" />
                        <path
                            d="M19.9722 10.2471V8.45286V6.72415C19.9722 5.67759 19.6462 4.87588 18.995 4.31739C18.3438 3.75972 17.419 3.48047 16.2215 3.48047C15.0936 3.48047 14.1804 3.72778 13.4825 4.22158C12.7846 4.7162 12.389 5.41063 12.2964 6.30569H14.146C14.2156 5.91016 14.4277 5.59406 14.7824 5.35494C15.1371 5.11664 15.5876 4.99708 16.1347 4.99708C16.7507 4.99708 17.2339 5.13957 17.582 5.42455C17.931 5.70953 18.1054 6.10178 18.1054 6.60132V7.14179L15.8554 7.14179C14.6112 7.14179 13.6635 7.3891 13.0123 7.8829C12.3612 8.37752 12.0352 9.08342 12.0352 10.0014C12.0352 10.8154 12.3374 11.455 12.9419 11.9201C13.5464 12.3852 14.3491 12.6178 15.3492 12.6178C16.6401 12.6178 17.623 12.106 18.2971 11.0832C18.2971 11.5483 18.4249 11.9029 18.6813 12.1469C18.9368 12.391 19.3554 12.513 19.9369 12.513H19.9722V10.2471ZM18.1054 8.85167C18.094 9.54937 17.8695 10.107 17.4338 10.5255C16.998 10.944 16.3903 11.1536 15.6113 11.1536C15.0994 11.1536 14.6956 11.0373 14.3991 10.8048C14.1025 10.5722 13.9543 10.2643 13.9543 9.88021C13.9543 9.43882 14.1116 9.10389 14.4253 8.87787C14.739 8.65103 15.187 8.53803 15.7686 8.53803L18.1063 8.53803V8.85167H18.1054Z"
                            fill="#121A0F" />
                        <path d="M19.9716 8.53857H18.0918V12.5299H19.9716V8.53857Z" fill="#121A0F" />
                        <path
                            d="M48.9736 10.2402V8.44602V6.71732C48.9736 5.67075 48.6476 4.86905 47.9964 4.31055C47.3453 3.75288 46.4205 3.47363 45.223 3.47363C44.0951 3.47363 43.1818 3.72094 42.484 4.21474C41.7861 4.70936 41.3905 5.40379 41.2979 6.29885H43.1474C43.217 5.90332 43.4292 5.58723 43.7839 5.34811C44.1385 5.1098 44.589 4.99025 45.1362 4.99025C45.7521 4.99025 46.2354 5.13273 46.5835 5.41771C46.9324 5.70269 47.1069 6.09495 47.1069 6.59448V7.13496L44.8569 7.13496C43.6127 7.13496 42.665 7.38227 42.0138 7.87607C41.3626 8.37068 41.0366 9.07658 41.0366 9.99457C41.0366 10.8086 41.3389 11.4481 41.9434 11.9133C42.5478 12.3784 43.3506 12.611 44.3507 12.611C45.6416 12.611 46.6245 12.0992 47.2986 11.0763C47.2986 11.5415 47.4264 11.8961 47.6827 12.1401C47.9383 12.3841 48.3568 12.5062 48.9384 12.5062H48.9736V10.2402ZM47.1069 8.84483C47.0954 9.54254 46.871 10.1002 46.4353 10.5187C45.9995 10.9371 45.3917 11.1468 44.6128 11.1468C44.1008 11.1468 43.697 11.0305 43.4005 10.7979C43.104 10.5653 42.9558 10.2574 42.9558 9.87337C42.9558 9.43198 43.113 9.09705 43.4267 8.87104C43.7404 8.64502 44.1885 8.53119 44.77 8.53119L47.1077 8.53119V8.84483H47.1069Z"
                            fill="#121A0F" />
                        <path d="M48.9731 8.53174H47.0933V12.5231H48.9731V8.53174Z" fill="#121A0F" />
                        <path d="M58.4346 12.5844L54.9461 3.58545L53.0605 3.58545L56.5491 12.5844L58.4346 12.5844Z"
                            fill="#121A0F" />
                        <path
                            d="M60.4387 3.58627L56.9822 12.5344L57.0018 12.5852L56.6357 13.4393C56.625 13.4655 56.6152 13.4868 56.6046 13.5114L56.5906 13.5466L56.5898 13.5458C56.4555 13.8652 56.3244 14.0814 56.1991 14.1804C56.0599 14.291 55.8092 14.3459 55.4488 14.3459H54.1235V16.0025H56.1467C56.5767 16.0025 56.9199 15.9296 57.1755 15.7847C57.431 15.6397 57.6464 15.4244 57.8209 15.1394C57.9954 14.8544 58.187 14.4449 58.3967 13.9102L62.4439 3.58545L60.4387 3.58545V3.58627Z"
                            fill="#121A0F" />
                        <path d="M23.2398 3.58057L21.373 3.58057V11.7467H23.2398V3.58057Z" fill="#121A0F" />
                        <path
                            d="M33.565 1.13418C33.565 1.46011 33.4544 1.73035 33.2333 1.94572C33.0121 2.16109 32.7385 2.26837 32.4134 2.26837C32.0874 2.26837 31.8138 2.16109 31.5934 1.94572C31.3723 1.73035 31.2617 1.46011 31.2617 1.13418C31.2617 0.808259 31.3723 0.538021 31.5934 0.322649C31.8146 0.107277 32.0882 0 32.4134 0C32.7394 0 33.0129 0.107277 33.2333 0.322649C33.4552 0.538021 33.565 0.808259 33.565 1.13418ZM33.3561 3.57698V12.5104H31.4714V3.57698L33.3561 3.57698Z"
                            fill="#121A0F" />
                        <path d="M7.67676 0.19873L11.0612 0.19873V3.58245L7.67676 0.19873Z" fill="#52D3A2" />
                        <path
                            d="M9.05424 8.35994C8.85602 9.13872 8.47596 9.74962 7.91161 10.191C7.34726 10.6332 6.64693 10.8543 5.80982 10.8543C5.0538 10.8543 4.39115 10.6652 3.82106 10.2876C3.25098 9.91013 2.81522 9.38357 2.51297 8.70961C2.21073 8.03565 2.0592 7.26834 2.0592 6.40767C2.0592 5.53553 2.21073 4.76576 2.51297 4.09672C2.81522 3.42849 3.2518 2.90521 3.82106 2.52688C4.37068 2.16246 5.00793 1.97575 5.73037 1.96265V1.96101H5.78688C5.79426 1.96101 5.80163 1.9602 5.80982 1.9602C5.81719 1.9602 5.82374 1.96101 5.83112 1.96101H6.11206V0.203644C6.0408 0.201187 5.96954 0.19873 5.89746 0.19873C4.71142 0.19873 3.67363 0.457505 2.78327 0.975053C1.89374 1.49178 1.20734 2.21815 0.724077 3.15416C0.241632 4.09017 0 5.1744 0 6.40685C0 7.65077 0.241632 8.74155 0.724077 9.67674C1.20652 10.6127 1.89292 11.3367 2.78246 11.8485C3.67199 12.3603 4.70978 12.6158 5.89664 12.6158C6.82713 12.6158 7.65851 12.4414 8.39078 12.0925C9.12305 11.7437 9.71935 11.2499 10.1789 10.6103C10.6384 9.97073 10.9316 9.22061 11.0594 8.36076H9.05424V8.35994Z"
                            fill="#121A0F" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
</script>
<script>
    let {{$chartId}}labelsVisible = false
    let {{$chartId}}chart = null
    let {{$chartId}}period = 'arps'
    let {{$chartId}}data = {!!json_encode($chartData)!!};
    let {{$chartId}}reverseData = false;
    document.addEventListener('DOMContentLoaded', function() {
        initChart()
    })
    let {{$chartId}}filteredData = {!!json_encode($chartData)!!}

    function showLabels(v){
        labelsVisible = v
        initChart({{$chartId}}filteredData)
    }
    let {{$chartId}}chartType = 'values'
    function typeChanged(type){
        {{$chartId}}chartType = type
        {{$chartId}}filteredData[{{$chartId}}period == 'arps' ? 'annual' : 'quarterly'].forEach((value, pindex) => {
            let {{$chartId}}finalData = []
            value.data.forEach((data, cindex) => {
                if(type == 'percentage'){
                    data.y = data.percentage
                }
                else {
                    data.y = data.revenue
                }
                {{$chartId}}finalData.push(data)
            })
            {{$chartId}}filteredData[pindex].data = {{$chartId}}finalData
        })
        initChart({{$chartId}}filteredData)
    }
    Livewire.on("decimalChanged", () => {
        initChart({{$chartId}}filteredData)
    })

    Livewire.on('periodChanged', (v) => {
        {{$chartId}}period = v
        initChart({{$chartId}}filteredData)
    })

    Livewire.on('unitChanged', (v) => {
        {{$chartId}}filteredData = {!!json_encode($chartData)!!}
        {{$chartId}}filteredData[{{$chartId}}period == 'arps' ? 'annual' : 'quarterly'].forEach((value, pindex) => {
            let {{$chartId}}finalData = []
            value.data.forEach((data, cindex) => {
                if(v == 'thousands'){
                    data.y = parseInt(data.y) / 1000
                    {{$chartId}}finalData.push(data)
                }

                if(v == 'millions'){
                    data.y = parseInt(data.y) / 1000000
                    {{$chartId}}finalData.push(data)
                }

                if(v == 'billions'){
                    data.y = parseInt(data.y) / 1000000000
                    {{$chartId}}finalData.push(data)
                }

                if(v == '0'){
                    {{$chartId}}finalData.push(data)
                }
            })
            {{$chartId}}filteredData[{{$chartId}}period == 'arps' ? 'annual' : 'quarterly'][pindex].data = {{$chartId}}finalData
        })

        initChart({{$chartId}}filteredData)
    })
    Livewire.on('orderChanged',(v) => {
        {{$chartId}}reverseData = v
        initChart({{$chartId}}filteredData)
    })
    Livewire.on('analysisDatesChanged', (dates) => {
        {{$chartId}}filteredData = {!!json_encode($chartData)!!}
        let {{$chartId}}startDate = dates[0]
        let {{$chartId}}endDate = dates[1]
        {{$chartId}}filteredData[{{$chartId}}period == 'arps' ? 'annual' : 'quarterly'].forEach((value, pindex) => {
            let {{$chartId}}finalData = []
            value.data.forEach((data, cindex) => {
                let {{$chartId}}currentDate = parseInt(new Date(data.x).getFullYear())
                if(!(currentDate < parseInt(startDate) || currentDate > parseInt(endDate))){
                    {{$chartId}}finalData.push(data)
                }
            })
            {{$chartId}}filteredData[{{$chartId}}period == 'arps' ? 'annual' : 'quarterly'][pindex].data = {{$chartId}}finalData
        })
        initChart({{$chartId}}filteredData)
    })

    document.addEventListener('refreshChart', (data) => {
        {{$chartId}}filteredData = data.detail
        initChart({{$chartId}}filteredData)
    })

    const {{$chartId}}getOrCreateTooltip = (chart) => {
            let {{$chartId}}tooltipEl = chart.canvas.parentNode.querySelector('div');

            if (!{{$chartId}}tooltipEl) {
                {{$chartId}}tooltipEl = document.createElement('div');
                {{$chartId}}tooltipEl.style.background = '#fff';
                {{$chartId}}tooltipEl.style.borderRadius = '25px';
                {{$chartId}}tooltipEl.style.color = 'black';
                {{$chartId}}tooltipEl.style.opacity = 1;
                {{$chartId}}tooltipEl.style.pointerEvents = 'none';
                {{$chartId}}tooltipEl.style.position = 'absolute';
                {{$chartId}}tooltipEl.style.transform = 'translate(-50%, 0)';
                {{$chartId}}tooltipEl.style.transition = 'all .1s ease';
                {{$chartId}}tooltipEl.style.minWidth = '230px';
                {{$chartId}}tooltipEl.style.filter =
                    'drop-shadow(0px 10.732307434082031px 21.464614868164062px rgba(50, 50, 71, 0.06)) drop-shadow(0px 10.732307434082031px 10.732307434082031px rgba(50, 50, 71, 0.08))';
                {{$chartId}}tooltipEl.classList.add('tooltip-caret')

                const {{$chartId}}table = document.createElement('table');
                table.style.margin = '0px';

                {{$chartId}}tooltipEl.appendChild(table);
                {{$chartId}}chart.canvas.parentNode.appendChild(tooltipEl);
            }

            return {{$chartId}}tooltipEl;
        };

        const {{$chartId}}externalTooltipHandler = (context) => {
            // Tooltip Element
            const {
                chart,
                tooltip
            } = context;
            const {{$chartId}}tooltipEl = getOrCreateTooltip(chart);

            // Hide if no tooltip
            if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }

            // Set Text
            if (tooltip.body) {
                const {{$chartId}}titleLines = tooltip.title || [];
                const {{$chartId}}bodyLines = tooltip.body.map(b => b.lines);

                const {{$chartId}}tableHead = document.createElement('thead');

                tableHead.style.color = '#3561E7';
                tableHead.style.textAlign = 'left';
                tableHead.style.marginBottom = '8px';

                titleLines.forEach(title => {
                    const {{$chartId}}tr = document.createElement('tr');
                    tr.style.borderWidth = 0;

                    const {{$chartId}}th = document.createElement('th');
                    th.style.borderWidth = 0;
                    const {{$chartId}}text = document.createTextNode(title);

                    th.appendChild(text);
                    tr.appendChild(th);
                    tableHead.appendChild(tr);
                });

                const {{$chartId}}tableBody = document.createElement('tbody');
                bodyLines.reverse().forEach((body, i) => {
                    const [label, value] = body[0].split('|');

                    //label

                    const {{$chartId}}trLabel = document.createElement('tr');
                    trLabel.style.backgroundColor = 'inherit';
                    trLabel.style.borderWidth = '0';
                    trLabel.style.fontSize = '12px';
                    trLabel.style.fontWeight = '400';
                    trLabel.style.color = '#464E49';
                    trLabel.style.paddingBottom = '0px';
                    trLabel.style.marginBottom = '0px';


                    const {{$chartId}}tdLabel = document.createElement('td');
                    tdLabel.style.borderWidth = 0;

                    const {{$chartId}}textLabel = document.createTextNode(label);

                    tdLabel.appendChild(textLabel);
                    trLabel.appendChild(tdLabel);

                    tableBody.appendChild(trLabel);


                    //value
                    const {{$chartId}}tr = document.createElement('tr');
                    tr.style.backgroundColor = 'inherit';
                    tr.style.borderWidth = '0';
                    tr.style.fontSize = '16px';
                    tr.style.fontWeight = '700';
                    tr.style.color = '#464E49';

                    const {{$chartId}}td = document.createElement('td');
                    td.style.borderWidth = 0;

                    const {{$chartId}}text = document.createTextNode(value);

                    td.appendChild(text);
                    tr.appendChild(td);

                    tableBody.appendChild(tr);
                });

                const {{$chartId}}tableRoot = tooltipEl.querySelector('table');

                // Remove old children
                while (tableRoot.firstChild) {
                    tableRoot.firstChild.remove();
                }

                // Add new children
                tableRoot.appendChild(tableHead);
                tableRoot.appendChild(tableBody);
            }

            const {
                offsetLeft: positionX,
                offsetTop: positionY
            } = chart.canvas;

            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.left = positionX + tooltip.caretX + 'px';
            tooltipEl.style.top = positionY + tooltip.caretY - 155 + 'px';
            tooltipEl.style.font = tooltip.options.bodyFont.string;
            tooltipEl.style.padding = 8 + 'px ' + 19 + 'px';
        };

        function initChart({{$chartId}}filteredData = null) {
            if ({{$chartId}}chart) {{$chartId}}chart.destroy();
            if({{$chartId}}filteredData){
                {{$chartId}}data = {{$chartId}}filteredData
            }

            if({{$chartId}}period == 'arps'){
                {{$chartId}}data = {{$chartId}}data['annual']
            }
            else {
                {{$chartId}}data = {{$chartId}}data['quarterly']
            }

            let {{$chartId}}canvas = document.getElementById("{{$chartId}}canvas");
            if (!{{$chartId}}canvas) return;
            let {{$chartId}}ctx = document.getElementById('{{$chartId}}canvas').getContext("2d");
            let {{$chartId}}gradientBg = {{$chartId}}ctx.createLinearGradient(0, 0, 0, {{$chartId}}canvas.height * 2.5)
            {{$chartId}}gradientBg.addColorStop(0.8, 'rgba(19,176,91,0.18)')
            {{$chartId}}gradientBg.addColorStop(1, 'rgba(19,176,91,0.05)')
            {{$chartId}}chart = new Chart({{$chartId}}ctx, {
                plugins: [ChartDataLabels, {
                    afterDraw: chart => {
                        if (chart.tooltip?._active?.length) {
                            let {{$chartId}}x = chart.tooltip._active[0].element.x;
                            let {{$chartId}}y = chart.tooltip._active[0].element.y;
                            let {{$chartId}}bottomBarY = chart.tooltip._active[1].element.y;
                            let {{$chartId}}ctx = chart.ctx;
                            {{$chartId}}ctx.save();
                            {{$chartId}}ctx.beginPath();
                            {{$chartId}}ctx.moveTo({{$chartId}}x, {{$chartId}}y);
                            {{$chartId}}ctx.lineTo({{$chartId}}x, {{$chartId}}bottomBarY + 9);
                            {{$chartId}}ctx.lineWidth = 1;
                            {{$chartId}}ctx.strokeStyle = '#13B05BDE';
                            {{$chartId}}ctx.setLineDash([5, 5])
                            {{$chartId}}ctx.stroke();
                            {{$chartId}}ctx.restore();
                        }
                    },
                }],
                maintainAspectRatio: false,
                aspectRatio: 3,
                responsive: true,
                type: 'bar',
                data: {
                    datasets: {{$chartId}}data
                },
                options: {
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    title: {
                        display: false,
                    },
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    plugins: {
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                            formatter: (v) => {
                                if({{$chartId}}chartType == 'values'){
                                    let {{$chartId}}value = parseInt(v.y)
                                        return {{$chartId}}value.toFixed(decimalPoints ?? 0)
                                }
                                else {
                                    return parseInt(v.y).toFixed(decimalPoints ?? 0) + '%'
                                }
                            },
                            font: {
                                weight: 400,
                                size: 12,
                            }
                        },
                        tooltip: {
                            bodyFont: {
                                size: 15
                            },
                            external: {{$chartId}}externalTooltipHandler,
                            enabled: false,
                            position: 'nearest',
                            callbacks: {
                                title: function(context) {
                                    const {{$chartId}}inputDate = new Date(context[0].label);
                                    const {{$chartId}}month = inputDate.getMonth() + 1;
                                    const {{$chartId}}day = inputDate.getDate();
                                    const {{$chartId}}year = inputDate.getFullYear();
                                    return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                                },
                                label: function(context) {
                                    return `${context.dataset.label}|${context.raw.y}`;
                                },
                            },
                        },
                        legend: {
                            display: {{$chartId}}labelsVisible,
                            position: 'bottom',
                            labels: {
                                boxWidth: 16,
                                boxHeight: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            stacked: true,
                            display: true,
                        },
                        x: {
                            stacked: true,
                            offset: true,
                            grid: {
                                display: false
                            },
                            type: 'timeseries',

                            align: 'center',
                        },
                    }
                }
            });
        }
</script>
@endpush
