<div class="flex flex-col divide-y">
    <div class="flex w-full flex-row {{$selected ? 'bg-blue-100' : 'bg-white'}}">
        <div
            wire:click.stop="select"
            class="cursor-default font-bold py-4 text-base w-[300px] truncate flex flex-row"
            style="padding-left: 10px;"
            title="{{$data['title']}}">
                <div class="ml-4 flex items-center justify-center" style="margin-left: {{$index * 20}}px;">
                    @if(count($data['children']) == 0)
                        <div class="w-4 h-4 mr-2"></div>
                    @elseif(!$open)
                        <svg wire:click.stop="toggle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 hover:cursor-pointer hover:text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    @else
                        <svg wire:click.stop="toggle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 hover:cursor-pointer hover:text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    @endif
                </div>

            <span class="whitespace-nowrap truncate">
                {{$data['title']}}
            </span>
        </div>
        <div class="w-full flex flex-row" wire:key="{{now()}}">
            @foreach($reverse ? array_reverse($data['values'], true) : $data['values'] as $year => $value)
                    <div class="w-[150px] flex items-center justify-center open-slide py-4 text-base  cursor-pointer hover:underline" data-value='{{$this->generateAttribute($value)}}'>
                        @if(!$value['empty'])
                            {{$value['value'] ? '$' : ''}} {{$value['present']}}
                        @endif
                    </div>
            @endforeach
        </div>
    </div>

    @if($open)
        @foreach($data['children'] as $value)
            <livewire:company-report-table-row key="{{now()}}" :data="$value" :index="$index + 1" :selectedRows="$selectedRows" :reverse="$reverse"/>
        @endforeach
    @endif
</div>

