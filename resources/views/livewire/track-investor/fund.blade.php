<div class="discover flex flex-col">
    <div wire:loading.flex class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent">
        <span class="mx-auto simple-loader !text-blue"></span>
    </div>
    @if(!$loading)
        <div class="flex-1 mt-6 ml-0 mr-0">
            <div class="grid gap-y-0 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4"> 
            @foreach($investors as $item)
                <div class="box shadow-md bg-[#ffffff] p-3 mt-2 mb-2 mr-3 border-0.5 rounded border-[#D4DDD7]">
                    <div class="flex content-center justify-between items-center">
                        <div>
                            <h4 class="text-base font-semibold text-[#3561E7]"><a href="{{url('fund/'.$item->cik.'/holdings')}}" class="cursor-pointer">{{$item->investor_name}}</a></h4>
                        </div>
                        <div  wire:click.prevent="handleFavorite('{{$item->investor_name}}')" class="p-1 bg-[width:3px_3px]  hover:bg-green-500 focus:bg-green-500 {{in_array($item->investor_name, $favorites) ? 'bg-green-500' : '' }} shadow-sm bg-[#F5F5F5] cursor-pointer">
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="{{in_array($item->investor_name, $favorites) ? '#fff' : 'currentColor' }}" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between content-between align-center w-full">
                        <div class="m-0 p-2 w-1/4 md:w-1/2">
                            <label class="font-normal text-sm">Market Value</label>
                            <div class="font-semibold text-base">{{niceNumber($item->total_value)}}</div>
                        </div>
                        <div class="m-0 p-2 w-1/4 md:w-1/2">
                            <label class="font-normal text-sm">Holdings</label>
                            <div class="font-semibold text-base">{{$item->portfolio_size}}</div>
                        </div>
                        <div class="mb-2 p-2 w-1/4 md:w-1/2">
                            <label class="font-normal text-sm">CIK</label>
                            <div class="font-semibold text-base">{{$item->cik ?? '--'}}</div>
                        </div>
                        <div class="mb-2 p-2 w-1/4 md:w-1/2">
                            <label class="font-normal text-sm">Turnover</label>
                            <div class="font-semibold text-base">{{niceNumber($item->change_in_total_value)}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($investors->hasMorePages())
                <button wire:click.prevent="loadMore"></button>
                <div
                    x-data="{
                        observe () {
                            let previousY = 0;
                            let observer = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    const currentY = window.scrollY;
                                    if (entry.isIntersecting && currentY > previousY) {
                                        @this.call('loadMore')
                                    }
                                    previousY = currentY;
                                })
                            }, {
                                root: null
                            })
                            observer.observe(this.$el)
                        },
                    }"
                x-init="observe"></div>
            @endif
            </div>
        </div>
    @endif
</div>