<div class="discover flex-1 mb-10">
    <div wire:loading.flex class="justify-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent company-profile-loading">
        <div class="grid place-content-center h-full" role="status">
            <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    @if(!$loading)
        <div class="flex-1 mt-6 ml-0 mr-0">
            <div class="grid gap-y-2 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
                @foreach($favorites as $item)
                    <div class="box shadow-md bg-[#ffffff] p-3 m-2 border-r-0.5">
                        <div class="flex content-center justify-between items-center">
                            <div>
                                <h4 class="text-[14px] font-semibold text-[#3561E7]">{{$item->investor_name}}</h4>
                            </div>
                            <div wire:click.prevent="removeFavorite('{{$item->investor_name}}')" class="p-1 bg-[width:3px_3px] shadow-sm bg-[#52D3A2] hover:bg-gray-500 focus:bg-gray-500 in_array($item->investor_name, $removeFavorites) ? 'bg-gray-500' : ''">
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-y-0 md:grid-cols-2">
                            <div class="m-0 p-2">
                                <label class="font-normal text-[12px]">Market Value</label>
                                <div class="font-semibold text-[14px]">{{$item->total_value}}</div>
                            </div>
                            <div class="m-0 p-2">
                                <label class="font-normal text-[12px]">Holdings</label>
                                <div class="font-semibold text-[14px]">{{$item->portfolio_size}}</div>
                            </div>
                            <div class="m-0 p-2">
                                <label class="font-normal text-[12px]">CEO</label>
                                <div class="font-semibold text-[14px]">Warren Buffet</div>
                            </div>
                            <div class="m-0 p-2">
                                <label class="font-normal text-[12px]">Turnover</label>
                                <div class="font-semibold text-[14px]">{{$item->change_in_total_value}}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if($favorites->hasMorePages())
                    <button wire:click.prevent="loadMore">Loading More ....</button>
                    <div
                        x-data="{
                            observe () {
                                let observer = new IntersectionObserver((entries) => {
                                    entries.forEach(entry => {
                                        if (entry.isIntersecting) {
                                            @this.call('loadMore')
                                        }
                                    })
                                }, {
                                    root: null
                                })
                    
                                observer.observe(this.$el)
                            }
                        }"
                        x-init="observe"
                    ></div>
                @endif
            </div>
        </div>
    @endif
</div>