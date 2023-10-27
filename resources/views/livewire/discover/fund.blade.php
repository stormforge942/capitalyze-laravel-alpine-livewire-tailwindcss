<div class="discover flex flex-col">
    @if($loading)
        <div class="flex-1 mt-6 ml-0 mr-0">
            <div class="grid gap-y-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5">
                @foreach($discover as $item)
                    <div class="box shadow-md bg-[#ffffff] p-3 m-2 border-0.5 rounded border-[#D4DDD7]">
                        <div class="flex content-center justify-between items-center">
                            <div>
                                <h4 class="text-sm font-semibold text-[#3561E7]">{{$item['title']}}</h4>
                            </div>
                            <div class="p-1 bg-[width:3px_3px] shadow-sm bg-[#F5F5F5]">
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-y-0 md:grid-cols-2">
                            @foreach($item['items'] as $value)
                                <div class="m-0 p-2">
                                    <label class="font-normal text-xs">{{$value['label']}}</label>
                                    <div class="font-semibold text-sm">{{$value['value']}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>