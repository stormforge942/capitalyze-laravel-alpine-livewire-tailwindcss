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
        class="fixed top-0 left-0 z-40 hidden h-screen pt-10 bg-white border-r border-gray-200 lg:block dark:bg-gray-800 dark:border-gray-700 w-56"
        :class="collapsed ? 'w-20' : 'w-56'" aria-label="Sidebar">
        <div class="flex flex-col h-full px-6 pb-4 bg-white dark:bg-gray-800">
            <button class="absolute -right-3 top-40" :class="collapsed ? 'rotate-180' : ''" @click="toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 11H16V13H12V16L8 12L12 8V11Z"
                        fill="#121A0F" />
                </svg>
            </button>
            <div class="mb-10">
                <a href="{{ route('home') }}">
                    <svg class="inline" x-show="!collapsed" width="145" height="32" viewBox="0 0 145 32"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M54.4995 11.7754C55.1375 13.0003 55.4565 14.4355 55.4565 16.0823C55.4565 17.6871 55.1375 19.102 54.4995 20.327C53.8615 21.5519 52.9756 22.4986 51.8431 23.1669C50.7107 23.8352 49.4245 24.17 47.9832 24.17C46.8102 24.17 45.7908 23.954 44.9266 23.522C44.0624 23.09 43.3722 22.5029 42.8575 21.7621V30.1601H39.5225V8.17874H42.4254L42.827 10.5258C44.103 8.83834 45.8227 7.99463 47.9847 7.99463C49.426 7.99463 50.7121 8.3179 51.8446 8.96736C52.977 9.61681 53.8615 10.5504 54.4995 11.7754ZM52.0592 16.0823C52.0592 14.5181 51.6314 13.2526 50.7774 12.2856C49.9233 11.3187 48.8068 10.8345 47.4264 10.8345C46.0475 10.8345 44.9353 11.3129 44.0914 12.2697C43.2475 13.2265 42.8256 14.4775 42.8256 16.0214C42.8256 17.6059 43.2475 18.8918 44.0914 19.8805C44.9353 20.8677 46.0475 21.362 47.4264 21.362C48.8054 21.362 49.9219 20.8677 50.7774 19.8805C51.6329 18.8932 52.0592 17.6262 52.0592 16.0823Z"
                            fill="black" />
                        <path
                            d="M62.5811 11.1116V8.17888H65.3288V3.76318H68.6943V8.17743H72.4933V11.1101H68.6943V19.3529C68.6943 19.9705 68.8175 20.4083 69.0655 20.6649C69.312 20.9215 69.7339 21.0505 70.3313 21.0505H72.863V23.9832H69.6513C68.1491 23.9832 67.0529 23.6338 66.3627 22.9336C65.6725 22.2334 65.3288 21.1534 65.3288 19.6921V11.1116H62.5811Z"
                            fill="black" />
                        <path d="M94.083 2.37451V23.9862H90.748V2.37451H94.083Z" fill="black" />
                        <path
                            d="M126.304 8.17871V10.5562L117.472 21.0532H126.704V23.9859H112.994V21.6084L121.825 11.1114H113.364V8.17871H126.304Z"
                            fill="black" />
                        <path
                            d="M131.502 8.99634C132.665 8.32659 133.998 7.99316 135.501 7.99316C137.025 7.99316 138.368 8.30194 139.531 8.9195C140.694 9.53706 141.61 10.4112 142.279 11.5434C142.949 12.6756 143.292 14.0035 143.312 15.5256C143.312 15.9374 143.282 16.3592 143.22 16.7912H131.301V16.9768C131.383 18.3554 131.815 19.447 132.597 20.2487C133.379 21.0518 134.418 21.4533 135.716 21.4533C136.745 21.4533 137.61 21.2112 138.31 20.7271C139.01 20.2429 139.473 19.5586 139.699 18.6743H143.034C142.746 20.2806 141.97 21.5969 140.702 22.6261C139.435 23.6554 137.856 24.17 135.962 24.17C134.315 24.17 132.88 23.8366 131.654 23.1669C130.429 22.4971 129.482 21.5563 128.814 20.3414C128.144 19.1266 127.811 17.7175 127.811 16.1128C127.811 14.4862 128.135 13.0612 128.783 11.8362C129.435 10.6127 130.339 9.66608 131.502 8.99634ZM138.543 11.6521C137.772 11.0041 136.799 10.6794 135.625 10.6794C134.533 10.6794 133.592 11.0143 132.799 11.6826C132.007 12.3509 131.547 13.241 131.424 14.3529H139.917C139.773 13.2004 139.315 12.3001 138.543 11.6521Z"
                            fill="black" />
                        <path
                            d="M37.0378 19.9718V16.7956V13.7353C37.0378 11.8826 36.4607 10.4634 35.308 9.47473C34.1552 8.4875 32.5182 7.99316 30.3983 7.99316C28.4016 7.99316 26.7849 8.43096 25.5495 9.30512C24.3141 10.1807 23.6137 11.41 23.4499 12.9945H26.724C26.8472 12.2943 27.2228 11.7348 27.8506 11.3115C28.4785 10.8896 29.276 10.678 30.2446 10.678C31.335 10.678 32.1905 10.9302 32.8067 11.4347C33.4244 11.9392 33.7333 12.6336 33.7333 13.5179V14.4746H29.7501C27.5476 14.4746 25.8699 14.9124 24.7172 15.7866C23.5644 16.6622 22.9873 17.9118 22.9873 19.5369C22.9873 20.9779 23.5224 22.11 24.5925 22.9335C25.6626 23.7569 27.0836 24.1686 28.854 24.1686C31.1392 24.1686 32.8792 23.2625 34.0726 21.4519C34.0726 22.2753 34.2988 22.903 34.7526 23.335C35.205 23.767 35.946 23.983 36.9755 23.983H37.0378V19.9718ZM33.7333 17.5015C33.713 18.7367 33.3157 19.7239 32.5443 20.4647C31.7729 21.2054 30.697 21.5766 29.318 21.5766C28.4118 21.5766 27.6969 21.3707 27.172 20.959C26.6471 20.5473 26.3847 20.0022 26.3847 19.3223C26.3847 18.541 26.6631 17.948 27.2184 17.5479C27.7738 17.1464 28.5669 16.9463 29.5964 16.9463H33.7347V17.5015H33.7333Z"
                            fill="black" />
                        <path d="M37.0377 16.9463H33.71V24.012H37.0377V16.9463Z" fill="black" />
                        <path
                            d="M88.3884 19.9718V16.7956V13.7353C88.3884 11.8826 87.8113 10.4634 86.6585 9.47473C85.5058 8.4875 83.8687 7.99316 81.7488 7.99316C79.7522 7.99316 78.1354 8.43096 76.9 9.30512C75.6646 10.1807 74.9643 11.41 74.8004 12.9945H78.0745C78.1978 12.2943 78.5733 11.7348 79.2012 11.3115C79.829 10.8896 80.6265 10.678 81.5951 10.678C82.6855 10.678 83.541 10.9302 84.1573 11.4347C84.775 11.9392 85.0838 12.6336 85.0838 13.5179V14.4746H81.1007C78.8981 14.4746 77.2205 14.9124 76.0677 15.7866C74.915 16.6622 74.3379 17.9118 74.3379 19.5369C74.3379 20.9779 74.8729 22.11 75.943 22.9335C77.0131 23.7569 78.4341 24.1686 80.2046 24.1686C82.4898 24.1686 84.2298 23.2625 85.4231 21.4519C85.4231 22.2753 85.6493 22.903 86.1032 23.335C86.5556 23.767 87.2965 23.983 88.326 23.983H88.3884V19.9718ZM85.0838 17.5015C85.0635 18.7367 84.6662 19.7239 83.8948 20.4647C83.1234 21.2054 82.0475 21.5766 80.6686 21.5766C79.7623 21.5766 79.0475 21.3707 78.5226 20.959C77.9977 20.5473 77.7352 20.0022 77.7352 19.3223C77.7352 18.541 78.0136 17.948 78.569 17.5479C79.1243 17.1478 79.9175 16.9463 80.947 16.9463H85.0853V17.5015H85.0838Z"
                            fill="black" />
                        <path d="M88.3883 16.9463H85.0605V24.012H88.3883V16.9463Z" fill="black" />
                        <path d="M105.131 24.1096L98.9551 8.1792H95.6172L101.793 24.1096H105.131Z" fill="black" />
                        <path
                            d="M108.677 8.1787L102.558 24.0192L102.592 24.1091L101.944 25.6211C101.925 25.6675 101.908 25.7052 101.889 25.7487L101.864 25.811L101.863 25.8096C101.625 26.3749 101.393 26.7577 101.171 26.9331C100.925 27.1288 100.481 27.2259 99.8432 27.2259H97.4971V30.1586H101.079C101.84 30.1586 102.447 30.0296 102.9 29.773C103.352 29.5164 103.734 29.1351 104.042 28.6306C104.351 28.1261 104.691 27.4013 105.062 26.4547L112.226 8.17725H108.677V8.1787Z"
                            fill="black" />
                        <path d="M42.827 8.17871H39.5225V22.6348H42.827V8.17871Z" fill="black" />
                        <path
                            d="M61.1067 3.84715C61.1067 4.42412 60.9109 4.90251 60.5194 5.28377C60.1279 5.66503 59.6436 5.85494 59.068 5.85494C58.4909 5.85494 58.0066 5.66503 57.6165 5.28377C57.225 4.90251 57.0293 4.42412 57.0293 3.84715C57.0293 3.27018 57.225 2.79179 57.6165 2.41053C58.008 2.02926 58.4923 1.83936 59.068 1.83936C59.6451 1.83936 60.1294 2.02926 60.5194 2.41053C60.9124 2.79179 61.1067 3.27018 61.1067 3.84715ZM60.7369 8.17151V23.986H57.4005V8.17151H60.7369Z"
                            fill="black" />
                        <path d="M15.2725 2.18848H21.2639V8.17851L15.2725 2.18848Z" fill="#52D3A2" />
                        <path
                            d="M17.7129 16.6373C17.362 18.016 16.6892 19.0974 15.6901 19.8788C14.6911 20.6616 13.4513 21.053 11.9694 21.053C10.6311 21.053 9.45802 20.7182 8.44882 20.0499C7.43962 19.3816 6.66822 18.4494 6.13317 17.2564C5.59812 16.0633 5.32987 14.7049 5.32987 13.1813C5.32987 11.6374 5.59812 10.2747 6.13317 9.09037C6.66822 7.90744 7.44107 6.9811 8.44882 6.31135C9.42177 5.66625 10.5499 5.33572 11.8288 5.31253V5.30963H11.9288C11.9419 5.30963 11.9549 5.30818 11.9694 5.30818C11.9825 5.30818 11.9941 5.30963 12.0071 5.30963H12.5045V2.19864C12.3783 2.19429 12.2522 2.18994 12.1246 2.18994C10.025 2.18994 8.18782 2.64804 6.61167 3.56423C5.03697 4.47897 3.82187 5.76483 2.96637 7.4218C2.11232 9.07877 1.68457 10.9981 1.68457 13.1799C1.68457 15.3819 2.11232 17.3129 2.96637 18.9684C3.82042 20.6254 5.03552 21.9069 6.61022 22.8129C8.18492 23.719 10.0221 24.1713 12.1231 24.1713C13.7703 24.1713 15.2421 23.8625 16.5384 23.2449C17.8347 22.6274 18.8903 21.7532 19.7037 20.621C20.5172 19.4888 21.0363 18.1609 21.2625 16.6388H17.7129V16.6373Z"
                            fill="black" />
                    </svg>

                    <svg x-show="collapsed" width="32" height="32" viewBox="0 0 32 32" fill="none"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x-cloak>
                        <rect width="32" height="32" rx="4" fill="url(#pattern0)" />
                        <defs>
                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1"
                                height="1">
                                <use xlink:href="#image0_312_53717" transform="scale(0.00166667)" />
                            </pattern>
                            <image id="image0_312_53717" width="600" height="600"
                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAJYCAIAAAAxBA+LAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAFpRJREFUeNrs3T9sY8l9B/CV/wAHA8a9BVIYCJB96lJFT91ekdPb7q4IxC2NFEulc7VUFcDNUk1a6rpcY2o7X0WqsytSCRAXKUh1TiUqQIAtDPAJAYwDUihzeobs2z9aiaIkzpvPpxB0Z8CgZnj88jfzm3mPHgEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEB01gwBPKD8wrv/Psuyoigu/3F24fIfx+PxKrz4J9t//5O//iuTeLU//s8fTg//3Tissh8ZArgLl0kWfobfwy9bW1v1/3T5bxb/Aru2El9hq/86/bt//scf//QnpvsKf/jP3wtCQQgNV5ZlHXuffvpp+PmhIq95zn7/3//2T//y+a9+KQsRhJBW7NVRFyq8dDJPFiIIIenkC3XexsZGccGAyEIEITRcKPJC4IWCL/wMKWhAZCGCEJovy7JWqxXCr175NCCyEEEISQixt729XS9+Gg1ZiCCEhIq/Ov9ueYwBWYgghGjkeV4vfoafRkMWgiAkrfrvxYsX2l5kIbzXDwwBTRXybzAYzOfzfr8vBR8kC//vf/9oKBCEcN+Kouj1eiH/QgpaBZWFIAhJSLvdnlzodDq6YGQhCEJSked5XQL2+32nIGQhCEISUpZlCL+TkxMloCwEQUhaWq3W6EK73TYashAEIQkJyRdKwMFgoBFUFoIgJMUI7Pf77gKVhSAIEYHIQhCEJKAsSxEoC0EQkqKiKOp2GBEoC0EQkpaQfKEEnEwm2mFkIQhCktPtdkMEOhQhC0EQkpx6O/DVq1eOxstCEISkJSTfYDCwHSgLQRCSok6nEwpBj4mQhbIQQUhyQv0XqsBer2ctFFmIICTFQlBfKLIQQYhCEGQhgpCU1M/OVQgiCxGEJKduDe33+wpBZCGCkOQURREKQa2hyEIEISmq+2KcEUQWIghJTr0c2uv1DAWyEEFIciyHIgsRhKSr3W67Mg1ZiCAkUb1eT3coshBBSIrqTcFOp2MokIUIQlJMwdFoZFMQWYggJEVFUZycnISfhgJZiCAkxRQMtaBNQWQhgpAU1deHSkFkIYKQRFOw3+8bB2QhghApCLIQQYgUBFmIICQF/QvGAVmIICTRFAzloHFAFiIISVH7gnFAFiIISTQFrYgiCxGESEGQhQhCpCDIQhrhR4aAjyrLUgouy3g8Dj+n0+nZ2Vn9S1VVl//rW//Iwln4+a9++eOf/sRoIAhZgqIoBoOBcVhASLXZbHZ8fFzHWx2ByEIEITHJ89xt2jdKvqBOPrEnCxGERK9+yq4UvFqo+YbD4dHRUUg+q5qyEEFIo4QU9HzBDwnhd3h4GMIvBKHRkIUIQhqo3++XZWkc3pt/4afiTxYiCGky18e8JVR+r1+/ln+ykEZyjpC3FUXhsEQtxN7+/v76+vqzZ88ODg6kYOxZ6HwhgpCPy7JsNBoZh+l0urOz8/jx493dXbuAshBBSEIclhiPx6H+29zcDCWg94MsRBCSll6vl3KbaB2BgSOAshBBSIparVan0xGB3gmyEEFIivI8T7NBZjqdikBZiCCE704NprY1WFXVzs7O5uamCJSFCEJS1+12Uzs7Xx+K0A4jC2UhgpDvTg2+evUqnb93Op2GKnB3d9ehQGQhgpA/Xaudzt+7t7cXUjBkoalHFiII+U6oBfM8T6cQ7Ha7Jh1ZiCDkT8qyTOS8xP7+vkIQWYgg5HuyLEvhvERVVc+fP9/d3TXjyEIEId+TwqJoKAHX19eHw6HpRhYiCPmeoigavyhaL4dqDUUWIgh5j8Yviu7s7FgORRYiCHm/UAs2+GbtUAJ6cASyEEHIB+V53uDj8/UZCd2hyEIEIR/U6/WaeqdofX22h+giCxGEfFBZlq1Wq5F/2nA4DCmoNQZZiCDkI+VgI/+ug4OD58+fS0FkIYKQq7Tb7Ub2yIQU3NnZMb/IQgQhV8myrJHloBREFiIIuZZOp9O8HhkpiCxEEHLdcvDly5dSEGQhgjBRzTsyMZ1OpSCyEEHIteR53m63G5aCz549M7PIQgQh19Kwe2SqqnJeEFmIICTRclAKIgsRhCRdDu7s7LhHFFmIICTRcnBvb88jdpGFCEISLQdDBHa7XXOKLEQQkmI5OJvNHJZAFiIISbccdKE2shBByM1kWdaYxy3t7u5qkEEWIgi5mcbcLDocDvf3900oshBByM0042bRqqpsDSILEYTcWLvdbkY5GFLQ1iCyELixyWRyHr/BYGAqid2nf/s3//Af//r5r35pKOD+lGXZgBScz+fNe3oiyWbh069eGge4P/1+vwFB2JiWVwDuVZ7nDUjB0WhkKoH7pFmmOZpxlYxOUQAWdHJyEns56EJRABbUgDaZEOR6ZID7Z2m0IV68eBH7n7C3t+fgIACLCIVU7OXgZDIxj4CKkAU14LzB7u6ueQRgQaPRyJEJABLVgOODZVmaR+ChWBqNXuzrouML5hGABcV+y7ZyEIDFxb4uancQeHCWRuMW+7ro3t6eSQRgcVGvizo7CMCtxL4u2oxbwgF4MJ1OJ+qbRc0gsArsEUZsa2sr3hf/+vVrMwisgjVDEKksy+bzebyv//Hjx67YBlSELC7q43cHBwdSEBCE3Mr29na8L966KAC3Fe/z6LXJACpCbqsoijzPI33xX331lRkEBCG3EvUG4XA4NIOAIORW4j04EVJwNpuZQUAQkmhFeHh4aPoAuJWiKCJtk5nP51mWmUFARUii5eBwOHR8EBCE3Fa8G4TWRYEV5Iq1+MS7wOhaNUBFyG0VRRFpCloXBQQhywnCSF+5dVFAELIEUZ8gNH2AICTRinA6nVoXBQQh6QahdVFAELIEUZ8gNH2AICTRcrCqqul0avoAQchtbWxsxPiyx+OxuQMEIelWhEdHR+YOWFlulonJ+fl5jC97c3PT0iigIiTRctAGISAIWY48z2N82VIQEIQkXRHaIAQEIcuhZRRAECbN0ijAXdA1Go0YW0Zns9n6+rq5A1SEKAcBBCHpBeHx8bG5AwQhSxBpy6hOGUAQshxZlsX4si2NAoKQ5YjxwfTVBXMHCEISpRwEBCFLE+MjeQUhIAhJ2tnZmUEABCFLoGUUQBAmLdKWUZ0ygCBkOVwrAyAIBWFkZrOZiQMEIekShIAgZGkiPU1v4gBBSLpctw0IQgCAZTiPUIxX4QAqQgAQhLAMukaBWKwZghWXZdl8Po/vjbXmrQWoCFmGSC8aBRCEpMshQkAQkjS3jAKCEAAEIctgjxBAECYt0ocRAghC0nV0dGQQAEEIAIIQAAQhAAhCABCEACAIAUAQAoAgBABBCACCEAAEIQAIQgAQhAAgCAFAEAKAIAQAQQgAghAABCEACEJW2NbWlkEABCHLUVWVQQAQhOmaTqcGAUAQAoAgJBJlWRoEQBACgCDk1mazmUEAEISCMDJFUZg7QBCSrizLDAIgCBGEAIKQW4vxKKGlUUAQsjQulwEQhERmY2PDIACCkOWIcWnUHiEgCFmas7Oz6F6zPUJAELI0Me4RqggBQcjSRPoACjeOAoKQpCkKAUFI0hWhbUJAELIckZ4jfPLkibkDBCHpFoV5nps4QBCSblGoWQYQhCRdESoKAUHI0sR4pv6RfhlAEJJ4RSgIAUHIckTaOLq1tWXugBW3ZghicX5+HmN+P3782NwBKkKWYDabRfeasyzTLwMIQtINwke2CQFByLJE2i9jmxAQhCzH6empihBAEKoII+N+GUAQknQQykJAELIcVVVF2i8jCAFByHJEGoT6ZQBByHIcHR1FWhF6Wj0gCFkC24QAglAQRsnqKLCy3DUamfl8HuMy42w2W19fN32AipDbGo/HMb7s/ILpAwQht3V8fBzpK2+1WqYPEIQkWhEGL168MH3ACrJHGJ8YH0xYW19fj/QoJKAiZIU4RAEgCJNmdRRAECYt0vtl6opQ7yiwan5kCFSE96nVau3v75tEbqMoiohO01ZVFe92BqyuyWRyHqfwyk0ftxTXe77f75uyFWdpVFF439/lrY5yG9G1XJ2enpo1QcjyxbtNGLx8+dIMsrDt7e24XrB10dXnHGGs4j1NWFXV48ePzSCLmUwmRVFE9II3NzdloYqQOxHv6miWZe122wyygDzP40pBFaEg5A4dHh7G++IdKGQx0W0QRt3jLQjxH9jdfpxpmWEB0W0QulNQEHKHptNp1P+NaZnhprIsi+4ZJvE+LkYQEofhcBjvi2+32zE+YZgHFOOTvGwQCkLuVtSHKLTMcFPRrYs+skcYCccn4jafz+Otq2az2fr6uknkmt+cwrs9unJwc3PT3KkIuVtRr47mea4o5JpifKtYFxWE3IeoD1EEr169MolcR4xHbqLevICYzOfz85h5Wi8fVRRFjO9tZ4RUhNyTqFdHFYVcR4yHbaqqcohQEHJPYl8dLS+YRz4kxuODj/SLCkLuuSIM3z2j/hN6vZ555ENCCsbYGm2DEO5Vv98/j5z2UT7k5OQkxrd0dJeDQ9wibSX4S+HDzjzy3nIwxvdzdEceE2dptAliv3f00cWZwk6nYyp5S6R30sbewgZRCikSe1EY9S053IWyLC31AzeoqM7jp2uGvzQajSJ9J/tKBw9jMBg0IAu1GBB7OTiZTExfXOwRNsfr168b8FcoCqnFe9NC7Ed7IW6RNpq/RdcM8ZaDVjXggXW73QYEoa4Z4t0ddBAIHljIj/NGGAwGZjNZ7XZbwxewuAbcMlOL8XpJlvJlLuoVfuui8PAacMuMBdKURb28b10UVkW8+ytvCX+I2UxK7MdhrYvCqoj0ekYdpMT+Hc66KKyQZpyj8OGSlNivCbQuCqsl6r67dz9fbBY2Xp7n8/nc6gWgKHSaIlEN2NgOWW4eQVF4h7rdrjltqgY8O8V3NVAUOlnIgppx4Mdzl0BReE8nCzXONEzsx+cv35mmEhSFTtmziGY8O8y6PSgK79VkMpGFzdCArUFtMqAodOMMC2rMtQ/9ft9sgqLQpw83UxRF7KcGL5VlaUIhApPJRBayIprRIHO5UG9CIQ5RP+9bFjYsBZv0tcypCYhJYx5JIQul4IpwuShEJvYH3MjCBmjMU6OVgxCrXq8nC5GCykFIemGqMa16zhdKQeUgsIhGHqWQhSv+9at5+9PKQYhbU7tmau4jXbUUbOTRHeUgxK0Zl/1fnYU+p1ZBnueNTEHlYPP80BCk5s2bN+F7+tOnT5v6B37yySetVmttbW08HpvuB/y+9bvf/a6Rl3Du7u5Op1NTDNEvWDXvAtJ3jUYjW4YPIlTkTW3Lcs8tNEdT75p5d5nUVZD3rMGndM7dLAo+sCLlcXH3ttLQ7FaswWBglsECacQnKzw07q7XGBp8SrXmLQQWSKNfJu10Oibd6oJ1BSDRBdLLZgcHDZcoDGYjz0i8e2RC4xU0eYE0hQ+yd7/d+1y7/TsnDGMib5hWq2XGoeFf6s/TE77j+3RbWFmW6Www65GBJHQ6nfMkjUYjDfE3kud5CIaktpYtHkAqmt34frV+v68h8DproantKAcarCCtj7nGt7+Lw4XfG91uN8G3h3tkIDlpbhaKQxH4oUVR7wRIUbKbhe+WAom30oQM6PV6KS8S6KWCdDXvYeK36SwN3wxS65UoyzKpdhidosB7VsMSPFn40fXSxtcHoQTsdrvpHIq4+guQTlFIXfhMTLxx5kObRiERG3bcInzit9vtlHuG3+VEDfAdjTMfTcRQI8ZbN4TvOp1OR/69y52iCVozBHxIKBTCx71xuNp4PD46OhpfWP3iL9Q6W1tbIcL1Q77XcDh8/vy5cRCE8Gfh2/GrV6+Mw41CcTqdhl+qqlqRyj4I4Vf/Yo6uMJvNNjc3V2TiEISskFAUhtLQONxU+DwNiRhycXYh/H4Pn7D5hVD2PXnypP7FRFx/vp49examyVAIQniPwWDgTNWySsbwM3zanp2d1Ul5WYsE1/l/uMy2LMvqCm9jYyP8XkegEV7Yzs7OwcGBcRCE8H7hc9Zj/Giw/f393d1d4yAIQRaSIg0yCEJkIemaTqfPnj3TICMIQRaSIm2iCEIWkef5ZDJxARWx0ybKpR8YAm76JdpSElIQQUjSwsfH+vq6DxHitbOz4w2MIMQXatJNweFwaBy4ZI+QxemdIcYUdHAeQYgsRArCn/3QEHAb33777TfffPOzn/1MFiIFEYSkm4WHh4d5nstCpCCCkHSFLDw9PXU3N1IQQUi6ptPp8fHxF1988cknnxgNVkFVVZ999tlvfvMbQ8EVNMuwZEVRDAYDjwRiFVLQIR+uwzlCll8Xbm5u+vThwd+HUpBrsjTK8n377bdff/11lmVPnz41GjxUCl7zWccgCLkrv/3tb09PT8uytGXIfTo4OPjyyy/DtzFDAayEoigmk8k53ItOp+M/OlSErJY3b944cc89qKoqFIK//vWvDQWCkJVTn7i3TMrd0RrDbTg+wf3J87zf74c4NBQs0cHBwc7OjnFARUgEqqp6/fr12tqaLGRZ76hf/OIXe3t7hgIVIZEpiiKUhnYNuY3pdPr8+XNnJFAREqU3b958/fXXSkMWFqrAn//856EiNBSoCImbXUNuKpSAoRDUF4OKkIaodw3Pzs6ePn2qoZSP2t/fD4Wg5VCggbIsC6Wh8+B8yGQysakMNF9Zlq6h4S3z+bzb7fqvA0hIu90+OTkRAAQe6QWku1IaioBQCkiCZIUvQ7qoAHFo4zDRtVB3ZwP8WX3EQjwkotfrhS9A3vYA4jA5YX5tBwKIQxEIwDXisNfraaURgQBJqztLHbQQgQCpa7fbo9FItMTSERq+vohAgOWrH+1kvXSVzwWGryw6QgHuVvicDZ+27mlbtVVQR+MB7lvdUGMH8WFLwE6nYxUU4IFZMr3/XcAw4J4UQUQ8mJdUtFqt7e3tsizVKHehqqrhcHh4eBh+Gg0EIax6jfjixYuQiKoW+QeCkKSF0jDEYV0m6ma8kdlsFpLv6OhI/iEIoTllYqvV2tra0t94RfE3Ho/r8AtBaEAQhNBY9appHYqJV4qX4Rd+TqdT7w0EISQnz/PiQsjF8DOFXAyBF2Lv+Ph4esF7AEEIfC8X653FjY2NOiMbUPPVgReSbzabhQg0ywhC4MbRWBeLoWp8dLGyurKvts65o6Ojy/wLv5hEBCGwfHUc1jEZfqkz8tFFV86drq9eZlv45ezsrA68ywgEBCGsXFj+pevE5GW2XfFvAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGi0/xdgAOUPrQEqnnWMAAAAAElFTkSuQmCC" />
                        </defs>
                    </svg>
                </a>
            </div>
            <ul class="text-[14px] flex-1 overflow-x-hidden space-y-2">
                <li class="flex items-center w-full p-2 font-semibold rounded group text-blue">
                    <svg width="16" height="28" class="fill-current" viewBox="0 0 16 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.77966 5.31441C7.19566 5.31441 6.29165 4.65041 5.33965 4.67441C4.08365 4.69041 2.93165 5.40241 2.28365 6.53041C0.979648 8.79441 1.94765 12.1384 3.21965 13.9784C3.84365 14.8744 4.57965 15.8824 5.55565 15.8504C6.49165 15.8104 6.84366 15.2424 7.97966 15.2424C9.10766 15.2424 9.42766 15.8504 10.4197 15.8264C11.4277 15.8104 12.0677 14.9144 12.6837 14.0104C13.3957 12.9704 13.6917 11.9624 13.7077 11.9064C13.6837 11.8984 11.7477 11.1544 11.7237 8.91441C11.7077 7.04241 13.2517 6.14641 13.3237 6.10641C12.4437 4.81841 11.0917 4.67441 10.6197 4.64241C9.38766 4.54641 8.35566 5.31441 7.77966 5.31441ZM9.85966 3.42641C10.3797 2.80241 10.7237 1.93041 10.6277 1.06641C9.88366 1.09841 8.98766 1.56241 8.45166 2.18641C7.97166 2.73841 7.55566 3.62641 7.66766 4.47441C8.49166 4.53841 9.33966 4.05041 9.85966 3.42641Z" />
                    </svg>
                    <span class="ml-3 tag-collapsed">{{ $company->name }}  ({{ $company->ticker }})</span>
                </li>
                @foreach ($navbarItems as $item)
                    <?php
                    $child = $item['child'] ?? [];
                    $hasChild = count($child) > 0;
                    $tag = $hasChild ? 'button' : 'a';
                    ?>
                    <li @if ($hasChild) x-data="{open: false}" @endif>
                        <{{ $tag }} data-tooltip-target="tooltip-{{ $item['title'] }}"
                            data-tooltip-placement="right" href="{{ $item['url'] ?? '#' }}"
                            class="w-full flex items-center justify-between p-2 text-dark-light @if ($item['active'] ?? false) bg-green-light font-medium @else hover:bg-[#828c851a] @endif rounded group"
                            @if ($hasChild) data-dropdown-toggle="dropdownMore" data-dropdown-placement="left-end" @click.prevent="open = !open" @endif>
                            <div class="flex items-center gap-2">
                                {!! $item['icon'] !!}

                                <span class="tag-collapsed">{{ $item['title'] }}</span>
                            </div>

                            @if ($hasChild)
                                <svg class="tag-collapsed" :class="open ? 'rotate-90' : ''" width="16"
                                    height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.78126 8.00047L5.48145 4.70062L6.42425 3.75781L10.6669 8.00047L6.42425 12.2431L5.48145 11.3003L8.78126 8.00047Z"
                                        fill="#464E49" />
                                </svg>
                            @endif
                            </{{ $tag }}>

                            <div id="tooltip-{{ $item['title'] }}" role="tooltip"
                                class="absolute z-10 invisible hidden px-3 py-2 text-xs text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ $item['title'] }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            @if ($hasChild)
                                <ul class="py-2 space-y-2" :class="(!open || collapsed) ? 'hidden' : ''" x-cloak>
                                    <li>
                                        <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 @if($currentRoute === 'track-investor') font-bold @endif"
                                            href="{{ route('company.track-investor', ['ticker' => $this->company->ticker]) }}">
                                            Track Investors
                                        </a>
                                    </li>
                                    @foreach ($child as $childItem)
                                        <li>
                                            <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 @if ($childItem['active']) font-bold @endif"
                                                href="{{ $childItem['url'] }}">
                                                {{ $childItem['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="dropdownMore"
                                    class="hidden overflow-y-auto bg-white divide-y divide-gray-100 rounded-lg shadow max-h-64 w-44 dark:bg-gray-700">
                                    <div class="py-2 text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownTopButton" x-show="collapsed" x-cloak>
                                        <!-- More links -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('More') }}
                                        </div>

                                        <ul>
                                            @foreach ($child as $childItem)
                                                <li>
                                                    <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-4 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 @if ($childItem['active']) font-semibold @endif"
                                                        href="{{ $childItem['url'] }}">
                                                        {{ $childItem['title'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                    </li>
                @endforeach
            </ul>
            <button id="profileButton" data-dropdown-toggle="dropdownProfile" data-dropdown-placement="left-end"
                type="button"
                class="mt-5 inline-flex items-center font-semibold text-[14px] leading-4 focus:outline-none transition self-start">
                <div class="bg-[#52D3A2] w-9 h-9 leading-9 rounded-full mr-2">{{ Auth::user()->initials }}
                </div>

                <span class="tag-collapsed">{{ Auth::user()->name }}</span>

                <svg class="tag-collapsed" class="ml-[10px]" width="16" height="16" viewBox="0 0 16 16"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8.00033 2C7.26699 2 6.66699 2.6 6.66699 3.33333C6.66699 4.06667 7.26699 4.66667 8.00033 4.66667C8.73366 4.66667 9.33366 4.06667 9.33366 3.33333C9.33366 2.6 8.73366 2 8.00033 2ZM8.00033 11.3333C7.26699 11.3333 6.66699 11.9333 6.66699 12.6667C6.66699 13.4 7.26699 14 8.00033 14C8.73366 14 9.33366 13.4 9.33366 12.6667C9.33366 11.9333 8.73366 11.3333 8.00033 11.3333ZM8.00033 6.66667C7.26699 6.66667 6.66699 7.26667 6.66699 8C6.66699 8.73333 7.26699 9.33333 8.00033 9.33333C8.73366 9.33333 9.33366 8.73333 9.33366 8C9.33366 7.26667 8.73366 6.66667 8.00033 6.66667Z"
                        fill="black" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownProfile" class="z-10 hidden" aria-labelledby="profileButton">
                @include('partials.profile-dropdown')
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
                            fill="#121A0F" />
                    </svg>
                </button>
            </div>

            <ul class="my-6 overflow-y-scroll md:mt-10 space-y-7">
                @foreach ($navbarItems as $item)
                    <?php
                    $child = $item['child'] ?? [];
                    $hasChild = count($child) > 0;
                    ?>

                    <li @if ($hasChild) x-data="{open: false}" @endif>
                        <a href="{{ $item['url'] ?? '#' }}"
                            class="flex items-center justify-between w-full {{ $item['active'] ?? false ? 'font-semibold text-dark' : 'text-dark-light2' }} hover:text-dark"
                            @if ($hasChild) @click.prevent="open = !open" @endif>
                            <div class="flex items-center gap-2">
                                {!! $item['icon'] !!}

                                <span>{{ $item['title'] }}</span>
                            </div>

                            @if ($hasChild)
                                <svg :class="open ? 'rotate-90' : ''" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.78126 8.00047L5.48145 4.70062L6.42425 3.75781L10.6669 8.00047L6.42425 12.2431L5.48145 11.3003L8.78126 8.00047Z"
                                        fill="#464E49" />
                                </svg>
                            @endif
                        </a>

                        @if ($hasChild)
                            <ul class="mt-4 ml-6 space-y-4" x-show="open" x-transition.opacity x-cloak>
                                <li>
                                    <a class="flex items-center w-full text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 @if($currentRoute === 'track-investor') font-bold @endif"
                                        href="{{ route('company.track-investor', ['ticker' => $this->company->ticker]) }}">
                                        Track Investors
                                    </a>
                                </li>
                                @foreach ($child as $childItem)
                                    <li class="space-y-2">
                                        <a href="{{ $childItem['url'] ?? '#' }}"
                                            class="@if ($childItem['active'] ?? false) text-dark font-semibold @else text-dark-light2 hover:text-dark @endif">
                                            {{ $childItem['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @livewire('navigation-menu')
</div>
