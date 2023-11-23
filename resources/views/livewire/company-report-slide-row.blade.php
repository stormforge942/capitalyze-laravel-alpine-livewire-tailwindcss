<div class="w-full p-2">
    <div class="w-full flex flex-row justify-evenly border-b border-gray-300 p-2">
        <div class="block w-1/6"></div>
        @foreach($tableDates as $date)
            <div class="p-2 font-bold">{{$date}}</div>
        @endforeach
    </div>
    @foreach($rows as $row)
        <div class="flex flex-row justify-between items-center border-b border-gray-300 p-2">
            <div class="w-1/4">
                <span class="whitespace-nowrap truncate font-bold block">{{$row['title']}}</span>
            </div>
            <div class="w-3/4 flex flex-row justify-around">
                @foreach($row['values'] as $value)
                    <div class="p-2">
                        @php
                            $res = str_replace(',', '', $value['value']);
                            if(is_numeric($res)){
                                if($res < 0){
                                    $res = number_format(abs($res));
                                    $res = "($res)";
                                }
                            }
                        @endphp
                        <span data-value="{{$this->generateAttribute($value)}}" wire:click="" class="open-slide cursor-pointer hover:underline {{$res < 0 ? 'text-red' : 'text-black'}}">{{$res}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>


