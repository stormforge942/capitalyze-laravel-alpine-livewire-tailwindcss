<div>
    {{-- desktop sidebar --}}
    <aside id="default-sidebar" x-data="{
        collapsed: false,
        toggle() {
            this.collapsed = !this.collapsed
    
            if (this.collapsed) {
                document.body.classList.add('nav-collapsed')
    
                document.getElementById('default-sidebar').classList.remove('w-56')
    
                document.getElementById('main-container').classList.remove('lg:ml-56')
                document.getElementById('main-container').classList.add('lg:ml-20');
    
                document.getElementById('navigation').classList.remove('lg:ml-56');
                document.getElementById('navigation').classList.add('lg:ml-20');
            } else {
                document.body.classList.remove('nav-collapsed')
    
                document.getElementById('main-container').classList.remove('lg:ml-20');
                document.getElementById('main-container').classList.add('lg:ml-56')
    
                document.getElementById('navigation').classList.remove('lg:ml-20');
                document.getElementById('navigation').classList.add('lg:ml-56');
            }
        }
    }"
        class="fixed top-0 left-0 z-40 hidden h-screen pt-10 bg-white lg:block  w-56"
        :class="collapsed ? '!w-20' : 'w-56'" aria-label="Sidebar" style="box-shadow: 0px 4px 20px 0px #0000000D">
        <div class="flex flex-col h-full pb-4 bg-white">
            <button class="absolute -right-3 top-40" :class="collapsed ? 'rotate-180' : ''" @click="toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 11H16V13H12V16L8 12L12 8V11Z"
                        fill="#121A0F" />
                </svg>
            </button>
            <div class="mb-10 px-8" :class="collapsed ? '!px-0 mx-auto !mb-5' : ''">
                <a href="{{ route('home') }}">
                    <div class="flex items-center gap-x-1" x-show="!collapsed">
                        <svg class="inline" width="123" width="123" height="27" viewBox="0 0 123 27"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M46.2281 9.9356C46.7693 10.9692 47.0399 12.1801 47.0399 13.5696C47.0399 14.9236 46.7693 16.1174 46.2281 17.151C45.6869 18.1846 44.9354 18.9833 43.9747 19.5472C43.0141 20.1111 41.9231 20.3936 40.7005 20.3936C39.7054 20.3936 38.8407 20.2114 38.1076 19.8469C37.3746 19.4824 36.7891 18.987 36.3524 18.3619V25.4477H33.5234V6.90095H35.9859L36.3266 8.88124C37.409 7.45748 38.8678 6.74561 40.7017 6.74561C41.9243 6.74561 43.0153 7.01837 43.976 7.56634C44.9366 8.11432 45.6869 8.90203 46.2281 9.9356ZM44.158 13.5696C44.158 12.2498 43.7952 11.182 43.0707 10.3662C42.3462 9.55031 41.3991 9.14177 40.2282 9.14177C39.0584 9.14177 38.115 9.54542 37.3992 10.3527C36.6833 11.16 36.3254 12.2156 36.3254 13.5182C36.3254 14.8551 36.6833 15.9401 37.3992 16.7743C38.115 17.6073 39.0584 18.0244 40.2282 18.0244C41.3979 18.0244 42.345 17.6073 43.0707 16.7743C43.7964 15.9413 44.158 14.8723 44.158 13.5696Z"
                                fill="#121A0F" />
                            <path
                                d="M53.0859 9.37548V6.90103H55.4168V3.17529H58.2716V6.89981H61.4942V9.37426H58.2716V16.3291C58.2716 16.8502 58.3762 17.2196 58.5865 17.4361C58.7956 17.6526 59.1535 17.7615 59.6603 17.7615H61.8079V20.2359H59.0834C57.8091 20.2359 56.8793 19.9411 56.2938 19.3503C55.7083 18.7596 55.4168 17.8483 55.4168 16.6154V9.37548H53.0859Z"
                                fill="#121A0F" />
                            <path d="M79.8056 2.00391V20.2388H76.9766V2.00391H79.8056Z" fill="#121A0F" />
                            <path
                                d="M107.142 6.90088V8.90686L99.6498 17.7637H107.481V20.2382H95.8516V18.2322L103.342 9.37533H96.1652V6.90088H107.142Z"
                                fill="#121A0F" />
                            <path
                                d="M111.553 7.59105C112.54 7.02596 113.67 6.74463 114.946 6.74463C116.239 6.74463 117.378 7.00516 118.364 7.52623C119.35 8.04729 120.128 8.78486 120.695 9.74014C121.263 10.6954 121.555 11.8158 121.572 13.1002C121.572 13.4475 121.546 13.8035 121.493 14.168H111.382V14.3245C111.453 15.4878 111.819 16.4088 112.482 17.0852C113.145 17.7628 114.027 18.1017 115.128 18.1017C116.001 18.1017 116.734 17.8974 117.328 17.4889C117.922 17.0803 118.315 16.503 118.507 15.7569H121.336C121.091 17.1121 120.433 18.2227 119.358 19.0912C118.283 19.9596 116.943 20.3939 115.337 20.3939C113.94 20.3939 112.722 20.1125 111.683 19.5474C110.643 18.9823 109.84 18.1885 109.273 17.1635C108.705 16.1385 108.422 14.9496 108.422 13.5955C108.422 12.2232 108.697 11.0208 109.247 9.98722C109.799 8.95488 110.567 8.15615 111.553 7.59105ZM117.526 9.83188C116.872 9.28513 116.047 9.01114 115.05 9.01114C114.124 9.01114 113.326 9.29369 112.653 9.85757C111.981 10.4214 111.592 11.1725 111.487 12.1106H118.691C118.569 11.1382 118.181 10.3786 117.526 9.83188Z"
                                fill="#121A0F" />
                            <path
                                d="M31.4187 16.8516V14.1716V11.5896C31.4187 10.0264 30.9292 8.82889 29.9513 7.9947C28.9735 7.16173 27.5848 6.74463 25.7865 6.74463C24.0928 6.74463 22.7214 7.11402 21.6734 7.85159C20.6255 8.59038 20.0314 9.62761 19.8924 10.9645H22.6697C22.7743 10.3737 23.0928 9.9016 23.6254 9.54444C24.158 9.1885 24.8345 9.00992 25.6562 9.00992C26.5811 9.00992 27.3068 9.22275 27.8296 9.64841C28.3535 10.0741 28.6155 10.66 28.6155 11.4061V12.2134H25.2367C23.3684 12.2134 21.9452 12.5828 20.9674 13.3203C19.9895 14.0591 19.5 15.1135 19.5 16.4846C19.5 17.7005 19.9539 18.6557 20.8616 19.3505C21.7694 20.0453 22.9748 20.3926 24.4766 20.3926C26.4151 20.3926 27.8911 19.6282 28.9034 18.1004C28.9034 18.7952 29.0952 19.3248 29.4802 19.6893C29.864 20.0538 30.4925 20.2361 31.3658 20.2361H31.4187V16.8516ZM28.6155 14.7673C28.5983 15.8095 28.2613 16.6424 27.6069 17.2675C26.9526 17.8925 26.0399 18.2056 24.8702 18.2056C24.1014 18.2056 23.495 18.0319 23.0498 17.6846C22.6045 17.3372 22.3819 16.8773 22.3819 16.3036C22.3819 15.6443 22.6181 15.1441 23.0891 14.8065C23.5602 14.4677 24.233 14.2989 25.1063 14.2989H28.6168V14.7673H28.6155Z"
                                fill="#121A0F" />
                            <path d="M31.4166 14.2988H28.5938V20.2605H31.4166V14.2988Z" fill="#121A0F" />
                            <path
                                d="M74.9812 16.8516V14.1716V11.5896C74.9812 10.0264 74.4917 8.82889 73.5138 7.9947C72.536 7.16173 71.1473 6.74463 69.349 6.74463C67.6553 6.74463 66.2839 7.11402 65.2359 7.85159C64.1879 8.59038 63.5939 9.62761 63.4549 10.9645H66.2322C66.3368 10.3737 66.6553 9.9016 67.1879 9.54444C67.7205 9.1885 68.397 9.00992 69.2186 9.00992C70.1436 9.00992 70.8693 9.22275 71.3921 9.64841C71.916 10.0741 72.178 10.66 72.178 11.4061V12.2134H68.7992C66.9309 12.2134 65.5077 12.5828 64.5299 13.3203C63.552 14.0591 63.0625 15.1135 63.0625 16.4846C63.0625 17.7005 63.5164 18.6557 64.4241 19.3505C65.3319 20.0453 66.5373 20.3926 68.0391 20.3926C69.9776 20.3926 71.4536 19.6282 72.4659 18.1004C72.4659 18.7952 72.6577 19.3248 73.0427 19.6893C73.4265 20.0538 74.055 20.2361 74.9283 20.2361H74.9812V16.8516ZM72.178 14.7673C72.1608 15.8095 71.8238 16.6424 71.1694 17.2675C70.5151 17.8925 69.6024 18.2056 68.4327 18.2056C67.6639 18.2056 67.0575 18.0319 66.6123 17.6846C66.167 17.3372 65.9444 16.8773 65.9444 16.3036C65.9444 15.6443 66.1805 15.1441 66.6516 14.8065C67.1227 14.4689 67.7955 14.2989 68.6688 14.2989H72.1793V14.7673H72.178Z"
                                fill="#121A0F" />
                            <path d="M74.9791 14.2988H72.1562V20.2605H74.9791V14.2988Z" fill="#121A0F" />
                            <path d="M89.1794 20.3427L83.9408 6.90137H81.1094L86.3479 20.3427H89.1794Z"
                                fill="#121A0F" />
                            <path
                                d="M92.1864 6.90113L86.9958 20.2666L87.0253 20.3424L86.4755 21.6182C86.4595 21.6573 86.4448 21.6891 86.4288 21.7258L86.4079 21.7784L86.4067 21.7772C86.2049 22.2542 86.0081 22.5771 85.8199 22.7251C85.6108 22.8902 85.2345 22.9722 84.6933 22.9722H82.7031V25.4466H85.7412C86.387 25.4466 86.9023 25.3378 87.2861 25.1213C87.6699 24.9048 87.9933 24.5831 88.2553 24.1574C88.5173 23.7318 88.8052 23.1202 89.12 22.3215L95.1975 6.8999H92.1864V6.90113Z"
                                fill="#121A0F" />
                            <path d="M36.3266 6.90088H33.5234V19.0982H36.3266V6.90088Z" fill="#121A0F" />
                            <path
                                d="M51.8338 3.24632C51.8338 3.73314 51.6677 4.13678 51.3356 4.45847C51.0035 4.78016 50.5927 4.9404 50.1044 4.9404C49.6148 4.9404 49.204 4.78016 48.8731 4.45847C48.541 4.13678 48.375 3.73314 48.375 3.24632C48.375 2.7595 48.541 2.35586 48.8731 2.03417C49.2052 1.71248 49.6161 1.55225 50.1044 1.55225C50.5939 1.55225 51.0047 1.71248 51.3356 2.03417C51.6689 2.35586 51.8338 2.7595 51.8338 3.24632ZM51.5201 6.895V20.2384H48.6899V6.895H51.5201Z"
                                fill="#121A0F" />
                            <path d="M12.9531 1.84668H18.0355V6.90077L12.9531 1.84668Z" fill="#52D3A2" />
                            <path
                                d="M15.0261 14.0377C14.7284 15.2009 14.1577 16.1134 13.3103 16.7726C12.4628 17.4331 11.4111 17.7634 10.1541 17.7634C9.01879 17.7634 8.02372 17.4808 7.16764 16.917C6.31156 16.3531 5.6572 15.5666 5.20333 14.5599C4.74946 13.5533 4.52191 12.4072 4.52191 11.1216C4.52191 9.81898 4.74946 8.66921 5.20333 7.66989C5.6572 6.67179 6.31279 5.89019 7.16764 5.3251C7.99297 4.78079 8.94991 4.50191 10.0348 4.48234V4.47989H10.1196C10.1307 4.47989 10.1418 4.47867 10.1541 4.47867C10.1651 4.47867 10.175 4.47989 10.1861 4.47989H10.6079V1.855C10.5009 1.85133 10.3939 1.84766 10.2857 1.84766C8.50465 1.84766 6.94624 2.23417 5.60923 3.00721C4.27345 3.77902 3.24271 4.86396 2.51701 6.26203C1.79254 7.6601 1.42969 9.27957 1.42969 11.1204C1.42969 12.9784 1.79254 14.6076 2.51701 16.0045C3.24148 17.4026 4.27222 18.4838 5.608 19.2483C6.94378 20.0128 8.50219 20.3944 10.2845 20.3944C11.6817 20.3944 12.9302 20.1339 14.0298 19.6128C15.1294 19.0917 16.0249 18.3542 16.7149 17.3989C17.4049 16.4436 17.8453 15.3232 18.0371 14.0389H15.0261V14.0377Z"
                                fill="#121A0F" />
                        </svg>

                        <div class="text-xs font-bold text-green-dark leading-4 px-1.5 bg-dark border border-green-dark"
                            style="border-radius: 123px;">
                            BETA
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-1" x-show="collapsed" x-cloak>
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x-cloak>
                            <rect width="32" height="32" rx="4" fill="url(#pattern0)" />
                            <defs>
                                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1"
                                    height="1">
                                    <use xlink:href="#image0_312_53717" transform="scale(0.00166667)" />
                                </pattern>
                                <image id="image0_312_53717" width="600" height="600"
                                    xlink:href="data:image/png;base64,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" />
                            </defs>
                        </svg>

                        <div class="text-xs font-bold text-green-dark leading-4 px-1.5 bg-dark border border-green-dark"
                            style="border-radius: 123px;">
                            BETA
                        </div>
                    </div>
                </a>
            </div>

            <div class="text-[14px] flex-1 overflow-x-hidden overflow-y-auto px-navbar space-y-6">
                @foreach ($groups as $key => $group)
                    <x-nav-group :name="$group['name']" :items="$group['items']" :collapsed="$group['collapsed']">
                        <x-slot name="icon">
                            @if ($key === 'main')
                                <svg class="nav-group-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M9.97308 18H14.0269C14.1589 16.7984 14.7721 15.8065 15.7676 14.7226C15.8797 14.6006 16.5988 13.8564 16.6841 13.7501C17.5318 12.6931 18 11.385 18 10C18 6.68629 15.3137 4 12 4C8.68629 4 6 6.68629 6 10C6 11.3843 6.46774 12.6917 7.31462 13.7484C7.40004 13.855 8.12081 14.6012 8.23154 14.7218C9.22766 15.8064 9.84103 16.7984 9.97308 18ZM14 20H10V21H14V20ZM5.75395 14.9992C4.65645 13.6297 4 11.8915 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10C20 11.8925 19.3428 13.6315 18.2443 15.0014C17.624 15.7748 16 17 16 18.5V21C16 22.1046 15.1046 23 14 23H10C8.89543 23 8 22.1046 8 21V18.5C8 17 6.37458 15.7736 5.75395 14.9992ZM13 10.0048H15.5L11 16.0048V12.0048H8.5L13 6V10.0048Z"
                                        fill="#3561E7" />
                                </svg>
                            @elseif($key === 'company_research')
                                <svg class="nav-group-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M15.5 5C13.567 5 12 6.567 12 8.5C12 10.433 13.567 12 15.5 12C17.433 12 19 10.433 19 8.5C19 6.567 17.433 5 15.5 5ZM10 8.5C10 5.46243 12.4624 3 15.5 3C18.5376 3 21 5.46243 21 8.5C21 9.6575 20.6424 10.7315 20.0317 11.6175L22.7071 14.2929L21.2929 15.7071L18.6175 13.0317C17.7315 13.6424 16.6575 14 15.5 14C12.4624 14 10 11.5376 10 8.5ZM3 4H8V6H3V4ZM3 11H8V13H3V11ZM21 18V20H3V18H21Z"
                                        fill="#3561E7" />
                                </svg>
                            @elseif($key === 'builder')
                                <svg class="nav-group-icon" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.4319 10.7481C14.465 10.8048 14.4866 10.8675 14.4954 10.9325C14.5043 10.9976 14.5003 11.0638 14.4836 11.1272C14.4668 11.1907 14.4378 11.2503 14.3981 11.3026C14.3583 11.3549 14.3087 11.3988 14.252 11.4319L8.25196 14.9319C8.17549 14.9765 8.08854 15 8.00001 15C7.91147 15 7.82453 14.9765 7.74805 14.9319L1.74805 11.4319C1.63351 11.3651 1.5502 11.2555 1.51646 11.1272C1.48272 10.999 1.5013 10.8626 1.56812 10.748C1.63494 10.6335 1.74453 10.5502 1.87278 10.5165C2.00102 10.4827 2.13742 10.5013 2.25196 10.5681L8.00001 13.9211L13.7481 10.5681C13.8626 10.5013 13.999 10.4827 14.1272 10.5165C14.2555 10.5502 14.3651 10.6335 14.4319 10.7481ZM13.7481 7.56812L8.00001 10.9211L2.25196 7.56812C2.13742 7.50129 2.00102 7.48271 1.87278 7.51645C1.74453 7.5502 1.63494 7.6335 1.56812 7.74805C1.5013 7.86259 1.48272 7.99899 1.51646 8.12723C1.5502 8.25548 1.63351 8.36506 1.74805 8.43188L7.74805 11.9319C7.82453 11.9765 7.91147 12 8.00001 12C8.08854 12 8.17549 11.9765 8.25196 11.9319L14.252 8.43188C14.3665 8.36506 14.4498 8.25548 14.4836 8.12723C14.5173 7.99899 14.4987 7.86259 14.4319 7.74805C14.3651 7.6335 14.2555 7.5502 14.1272 7.51645C13.999 7.48271 13.8626 7.50129 13.7481 7.56812ZM1.74805 5.43188L7.74805 8.93188C7.82453 8.97649 7.91147 9 8.00001 9C8.08854 9 8.17549 8.97649 8.25196 8.93188L14.252 5.43188C14.3274 5.38785 14.3901 5.3248 14.4336 5.24902C14.4771 5.17325 14.5 5.08739 14.5 5C14.5 4.91261 14.4771 4.82675 14.4336 4.75098C14.3901 4.6752 14.3274 4.61215 14.252 4.56812L8.25196 1.06811C8.17549 1.02351 8.08854 1 8.00001 1C7.91147 1 7.82453 1.02351 7.74805 1.06811L1.74805 4.56812C1.67257 4.61215 1.60995 4.6752 1.56643 4.75098C1.52291 4.82675 1.50001 4.91261 1.50001 5C1.50001 5.08739 1.52291 5.17325 1.56643 5.24902C1.60995 5.3248 1.67257 5.38785 1.74805 5.43188Z"
                                        fill="#3561E7" />
                                </svg>
                            @elseif($key === 'more')
                                <svg class="nav-group-icon" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.0078 17.9971C17.0078 18.5494 17.4555 18.9971 18.0078 18.9971C18.5601 18.9971 19.0078 18.5494 19.0078 17.9971C19.0078 17.4448 18.5601 16.9971 18.0078 16.9971C17.4555 16.9971 17.0078 17.4448 17.0078 17.9971Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M11.0078 17.9971C11.0078 18.5494 11.4555 18.9971 12.0078 18.9971C12.5601 18.9971 13.0078 18.5494 13.0078 17.9971C13.0078 17.4448 12.5601 16.9971 12.0078 16.9971C11.4555 16.9971 11.0078 17.4448 11.0078 17.9971Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M5.00781 17.9971C5.00781 18.5494 5.45553 18.9971 6.00781 18.9971C6.56009 18.9971 7.00781 18.5494 7.00781 17.9971C7.00781 17.4448 6.56009 16.9971 6.00781 16.9971C5.45553 16.9971 5.00781 17.4448 5.00781 17.9971Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M17.0078 11.9971C17.0078 12.5494 17.4555 12.9971 18.0078 12.9971C18.5601 12.9971 19.0078 12.5494 19.0078 11.9971C19.0078 11.4448 18.5601 10.9971 18.0078 10.9971C17.4555 10.9971 17.0078 11.4448 17.0078 11.9971Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M11.0078 11.9971C11.0078 12.5494 11.4555 12.9971 12.0078 12.9971C12.5601 12.9971 13.0078 12.5494 13.0078 11.9971C13.0078 11.4448 12.5601 10.9971 12.0078 10.9971C11.4555 10.9971 11.0078 11.4448 11.0078 11.9971Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M5.00781 11.9971C5.00781 12.5494 5.45553 12.9971 6.00781 12.9971C6.56009 12.9971 7.00781 12.5494 7.00781 11.9971C7.00781 11.4448 6.56009 10.9971 6.00781 10.9971C5.45553 10.9971 5.00781 11.4448 5.00781 11.9971Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M17.0078 5.99707C17.0078 6.54935 17.4555 6.99707 18.0078 6.99707C18.5601 6.99707 19.0078 6.54935 19.0078 5.99707C19.0078 5.44479 18.5601 4.99707 18.0078 4.99707C17.4555 4.99707 17.0078 5.44479 17.0078 5.99707Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M11.0078 5.99707C11.0078 6.54935 11.4555 6.99707 12.0078 6.99707C12.5601 6.99707 13.0078 6.54935 13.0078 5.99707C13.0078 5.44479 12.5601 4.99707 12.0078 4.99707C11.4555 4.99707 11.0078 5.44479 11.0078 5.99707Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M5.00781 5.99707C5.00781 6.54935 5.45553 6.99707 6.00781 6.99707C6.56009 6.99707 7.00781 6.54935 7.00781 5.99707C7.00781 5.44479 6.56009 4.99707 6.00781 4.99707C5.45553 4.99707 5.00781 5.44479 5.00781 5.99707Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            @endif
                        </x-slot>
                    </x-nav-group>
                @endforeach
            </div>

            <div class="mt-5" :class="collapsed ? 'px-5' : 'px-8'" x-cloak>
                <x-dropdown placement="left-end">
                    <x-slot name="trigger">
                        <div class="inline-flex items-center gap-x-2 font-semibold"
                            :class="collapsed ? '!px-0 mx-auto' : ''">
                            <div class="bg-[#52D3A2] w-9 h-9 leading-9 rounded-full mr-2 shrink-0">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->initials }}" class="rounded-full w-full h-full" />
                                @else
                                    {{ Auth::user()->initials }}
                                @endif
                            </div>

                            <span class="tag-collapsed truncate max-w-[90px]">{{ Auth::user()->name }}</span>

                            <svg class="tag-collapsed" width="16" height="16" viewBox="0 0 16 16"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.00033 2C7.26699 2 6.66699 2.6 6.66699 3.33333C6.66699 4.06667 7.26699 4.66667 8.00033 4.66667C8.73366 4.66667 9.33366 4.06667 9.33366 3.33333C9.33366 2.6 8.73366 2 8.00033 2ZM8.00033 11.3333C7.26699 11.3333 6.66699 11.9333 6.66699 12.6667C6.66699 13.4 7.26699 14 8.00033 14C8.73366 14 9.33366 13.4 9.33366 12.6667C9.33366 11.9333 8.73366 11.3333 8.00033 11.3333ZM8.00033 6.66667C7.26699 6.66667 6.66699 7.26667 6.66699 8C6.66699 8.73333 7.26699 9.33333 8.00033 9.33333C8.73366 9.33333 9.33366 8.73333 9.33366 8C9.33366 7.26667 8.73366 6.66667 8.00033 6.66667Z"
                                    fill="black" />
                            </svg>
                        </div>
                    </x-slot>

                    @include('partials.profile-dropdown')
                </x-dropdown>
            </div>
        </div>
    </aside>

    <div class="overflow-y-auto block fixed top-0 left-0 w-full h-full min-h-screen z-30 px-10 pb-6 !bg-white md:px-20 lg:hidden"
        x-data="{ show: false }" @toggle-mobile-nav.window="show = !show" x-show="show" x-transition.opacity x-cloak>
        <div class="relative">
            <div class="sticky top-0 flex items-center justify-between pt-6 bg-white">
                <h3 class="pl-4 text-lg font-semibold">Menu</h3>
                <button @click="show=false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"
                        fill="none">
                        <path
                            d="M24.0014 21.173L32.4866 12.6877C33.2676 11.9066 34.534 11.9066 35.315 12.6877C36.096 13.4687 36.096 14.735 35.315 15.5161L26.8298 24.0014L35.315 32.4866C36.096 33.2676 36.096 34.534 35.315 35.315C34.534 36.096 33.2676 36.096 32.4866 35.315L24.0014 26.8298L15.5161 35.315C14.735 36.096 13.4687 36.096 12.6877 35.315C11.9066 34.534 11.9066 33.2676 12.6877 32.4866L21.173 24.0014L12.6876 15.5161C11.9066 14.735 11.9066 13.4687 12.6876 12.6876C13.4687 11.9066 14.735 11.9066 15.5161 12.6876L24.0014 21.173Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>

            <div class="my-6 overflow-y-auto md:mt-10 space-y-10">
                @foreach ($groups as $key => $group)
                    <div>
                        <div class="flex items-center gap-x-2 text-blue font-semibold">
                            @if ($key === 'main')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                    viewBox="0 0 16 17" fill="none">
                                    <path
                                        d="M6.64612 12.3805H9.34866C9.43666 11.5795 9.84546 10.9182 10.5091 10.1956C10.5839 10.1143 11.0633 9.61813 11.1201 9.54727C11.6853 8.8426 11.9974 7.97053 11.9974 7.0472C11.9974 4.83806 10.2065 3.0472 7.9974 3.0472C5.78826 3.0472 3.9974 4.83806 3.9974 7.0472C3.9974 7.97007 4.30922 8.84167 4.87381 9.54613C4.93076 9.6172 5.41127 10.1147 5.48509 10.1951C6.14917 10.9181 6.55808 11.5795 6.64612 12.3805ZM9.33073 13.7139H6.66406V14.3805H9.33073V13.7139ZM3.83336 10.38C3.1017 9.467 2.66406 8.3082 2.66406 7.0472C2.66406 4.10168 5.05188 1.71387 7.9974 1.71387C10.9429 1.71387 13.3307 4.10168 13.3307 7.0472C13.3307 8.30887 12.8926 9.4682 12.1603 10.3815C11.7467 10.8971 10.6641 11.7139 10.6641 12.7139V14.3805C10.6641 15.1169 10.0671 15.7139 9.33073 15.7139H6.66406C5.92768 15.7139 5.33073 15.1169 5.33073 14.3805V12.7139C5.33073 11.7139 4.24712 10.8963 3.83336 10.38ZM8.66406 7.0504H10.3307L7.33073 11.0504V8.38373H5.66406L8.66406 4.38053V7.0504Z"
                                        fill="#3561E7" />
                                </svg>
                            @elseif($key === 'company_research')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                    viewBox="0 0 16 17" fill="none">
                                    <path
                                        d="M10.3333 3.71419C9.04467 3.71419 8 4.75886 8 6.04753C8 7.33619 9.04467 8.38086 10.3333 8.38086C11.622 8.38086 12.6667 7.33619 12.6667 6.04753C12.6667 4.75886 11.622 3.71419 10.3333 3.71419ZM6.66667 6.04753C6.66667 4.02248 8.30827 2.38086 10.3333 2.38086C12.3584 2.38086 14 4.02248 14 6.04753C14 6.81919 13.7616 7.53519 13.3545 8.12586L15.1381 9.90946L14.1953 10.8523L12.4117 9.06866C11.821 9.47579 11.105 9.71419 10.3333 9.71419C8.30827 9.71419 6.66667 8.07259 6.66667 6.04753ZM2 3.04753H5.33333V4.38086H2V3.04753ZM2 7.71419H5.33333V9.04753H2V7.71419ZM14 12.3809V13.7142H2V12.3809H14Z"
                                        fill="#3561E7" />
                                </svg>
                            @elseif($key === 'more')
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.3359 11.9982C11.3359 12.3664 11.6344 12.6649 12.0026 12.6649C12.3708 12.6649 12.6693 12.3664 12.6693 11.9982C12.6693 11.63 12.3708 11.3315 12.0026 11.3315C11.6344 11.3315 11.3359 11.63 11.3359 11.9982Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7.33594 11.9982C7.33594 12.3664 7.6344 12.6649 8.0026 12.6649C8.3708 12.6649 8.66927 12.3664 8.66927 11.9982C8.66927 11.63 8.3708 11.3315 8.0026 11.3315C7.6344 11.3315 7.33594 11.63 7.33594 11.9982Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M3.33594 11.9982C3.33594 12.3664 3.63442 12.6649 4.0026 12.6649C4.37079 12.6649 4.66927 12.3664 4.66927 11.9982C4.66927 11.63 4.37079 11.3315 4.0026 11.3315C3.63442 11.3315 3.33594 11.63 3.33594 11.9982Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M11.3359 7.99821C11.3359 8.36641 11.6344 8.66488 12.0026 8.66488C12.3708 8.66488 12.6693 8.36641 12.6693 7.99821C12.6693 7.63001 12.3708 7.33154 12.0026 7.33154C11.6344 7.33154 11.3359 7.63001 11.3359 7.99821Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7.33594 7.99821C7.33594 8.36641 7.6344 8.66488 8.0026 8.66488C8.3708 8.66488 8.66927 8.36641 8.66927 7.99821C8.66927 7.63001 8.3708 7.33154 8.0026 7.33154C7.6344 7.33154 7.33594 7.63001 7.33594 7.99821Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M3.33594 7.99821C3.33594 8.36641 3.63442 8.66488 4.0026 8.66488C4.37079 8.66488 4.66927 8.36641 4.66927 7.99821C4.66927 7.63001 4.37079 7.33154 4.0026 7.33154C3.63442 7.33154 3.33594 7.63001 3.33594 7.99821Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M11.3359 3.99821C11.3359 4.3664 11.6344 4.66488 12.0026 4.66488C12.3708 4.66488 12.6693 4.3664 12.6693 3.99821C12.6693 3.63002 12.3708 3.33154 12.0026 3.33154C11.6344 3.33154 11.3359 3.63002 11.3359 3.99821Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7.33594 3.99821C7.33594 4.3664 7.6344 4.66488 8.0026 4.66488C8.3708 4.66488 8.66927 4.3664 8.66927 3.99821C8.66927 3.63002 8.3708 3.33154 8.0026 3.33154C7.6344 3.33154 7.33594 3.63002 7.33594 3.99821Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M3.33594 3.99821C3.33594 4.3664 3.63442 4.66488 4.0026 4.66488C4.37079 4.66488 4.66927 4.3664 4.66927 3.99821C4.66927 3.63002 4.37079 3.33154 4.0026 3.33154C3.63442 3.33154 3.33594 3.63002 3.33594 3.99821Z"
                                        stroke="#3561E7" stroke-width="1.83333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            @endif
                            <span>{{ $group['name'] }}</span>
                        </div>
                        <ul class="mt-6 space-y-8 text-md pl-6">
                            @foreach ($group['items'] as $item)
                                <li>
                                    <div class="inline-flex items-center gap-x-6">
                                        <a href="{{ $item['url'] ?? '#' }}"
                                            class="flex items-center justify-between w-full {{ $item['active'] ?? false ? 'font-semibold text-dark' : 'text-dark-light2' }} hover:text-dark">
                                            <div>
                                                {{ $item['title'] }}
                                            </div>
                                        </a>

                                        @if ($item['active'] ?? false)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path
                                                    d="M8.0026 14.6663C4.3207 14.6663 1.33594 11.6815 1.33594 7.99967C1.33594 4.31777 4.3207 1.33301 8.0026 1.33301C11.6845 1.33301 14.6693 4.31777 14.6693 7.99967C14.6693 11.6815 11.6845 14.6663 8.0026 14.6663ZM7.33767 10.6663L12.0517 5.95229L11.1089 5.00949L7.33767 8.78074L5.45208 6.89507L4.50926 7.83794L7.33767 10.6663Z"
                                                    fill="#3561E7" />
                                            </svg>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @livewire('navigation-menu')
</div>
