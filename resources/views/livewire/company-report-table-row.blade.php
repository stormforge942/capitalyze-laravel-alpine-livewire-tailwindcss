<div class="flex flex-col">
    <div class="flex w-full flex-row {{$selected ? 'bg-blue-100' : ($data['segmentation'] ? 'bg-[#52C6FF]/10' : 'bg-white')}}">
        <div
            wire:click.stop="select"
            class="cursor-default py-2 text-base w-[300px] truncate flex flex-row items-center"
            style="{{count($data['children']) == 0 ? 'padding-left: 20px;' : 'padding-left: 10px;'}}"
            title="{{$data['title']}}">
            <span class="whitespace-nowrap truncate">
                {{$data['title']}}
            </span>
            <div class="ml-2 flex items-center justify-center">
                @if(count($data['children']) == 0)
                    <div class="w-4 h-4 mr-2"></div>
                @elseif(!$open)
                    <svg wire:click.stop="toggle" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" class="rounded-full bg-[#2F88FF] hover:cursor-pointer py-[0.2em] px-[0.3em]">
                        <style>svg{fill:#ffffff}</style>
                        <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                    </svg>
                @else
                    <svg wire:click.stop="toggle" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="rounded-full bg-[#2F88FF] hover:cursor-pointer p-[0.2em]">
                        <style>svg{fill:#ffffff}</style>
                        <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/>
                    </svg>
                @endif
            </div>
        </div>
        <div class="w-full flex flex-row justify-end">
            @foreach($reverse ? array_reverse($data['values'], true) : $data['values'] as $year => $value)
                    <div wire:key="{{$year}}" class="w-[150px] flex items-center justify-center open-slide py-4 text-base  cursor-pointer hover:underline" data-value='{{$this->generateAttribute($value)}}'>
                        @if(!$value['empty'])
                            {{$value['present']}}
                        @endif
                    </div>
            @endforeach
        </div>
    </div>

    @if($open)
        @foreach($data['children'] as $key => $value)
            <livewire:company-report-table-row wire:key="{{$value['id']}}" :data="$value" :index="$index + 1" :selectedRows="$selectedRows" :reverse="$reverse"/>
        @endforeach
    @endif
</div>

