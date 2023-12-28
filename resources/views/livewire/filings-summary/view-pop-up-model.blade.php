<div @click.outside="open=true" class="text-left bg-white rounded-lg overflow-hidden shadow-xl sm:w-[100%] md:w-[60%]" @click.away="open = false">
    <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
        <span class="mx-auto simple-loader !text-blue"></span>
    </div>
    <div class=" bg-[#fff] p-3">
        <div class="flex justify-between items-center content-center">
            <div>
                <select wire:model="form_type" wire:change="handleFormType" class="rounded-lg border-2 border-[#D1D3D5] ring-1 ring-[#D1D3D5] outline-[#D1D3D5] p-2">
                    @foreach($rows as $row)
                        <option value="{{$row->form_type ?? $row['form_type']}}">From {{$row->form_type ?? $row['form_type']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-between items-center">
                <img class="mr-3 cursor-pointer" wire:click="handleZoomInOrZoomOut('decreament')" src="{{asset('/svg/zoom-out.svg')}}" alt="zoom out"/>
                <img class="mr-3 cursor-pointer" wire:click="handleZoomInOrZoomOut('increament')" src="{{asset('/svg/zoom-in.svg')}}" alt="zoom in"/>
                <img class="mr-3 cursor-pointer" wire:click="handleTransform()" src="{{asset('/svg/rotate.svg')}}" alt="rotate"/>
                <img class="mr-3 cursor-pointer" @click="$wire.closePopUp(); open = false" src="{{asset('/svg/close-cross-circle.svg')}}" alt="close cross circle"/>
            </div>
        </div>
    </div>    
    <div class="content bg-[#D1D3D5] p-0.5">
        <div class="flex flex-col bg-[#fff] my-0 mx-5 h-[30rem] overflow-y-auto px-2">
            <div class="flex flex-col divide-solid scale-{{$scale}} transform rotate-{{$transForm}}">
                {!! $s3_link !!}
            </div>
        </div>
    </div>
    <div class="footer bg-[#fff] p-3 ">
        <div class="flex justify-between items-center">
            <div class="flex justify-start items-center content-center">
                <img src="{{asset('/svg/previous.svg')}}" alt="prvious icon"/>
                @if($index > 0 )
                    <a href="#" wire:click.prevent="handleNexPage('{{$index - 1}}')" class=" text-[#2C71F0] text-base font-[500] ml-1">Previous Page</a>
                @else
                    <a href="#" wire:click.prevent="handleNexPage('{{$index - 1}}')" class="text-[#9DA3A8] text-base font-[500] ml-1">Previous Page</a>
                @endif
            </div>
            <h4 class="text-base font-[600] text-[#01090F]">Page {{1}} of {{1}}</h4>
            <div class="flex justify-start items-center content-center">
                @if($index >= 0 && $index < count($rows))
                    <a href="#" wire:click.prevent="handleNexPage({{$index + 1}})" class="text-[#2C71F0] font-[500] text-base mr-2">Next Page</a>
                @else 
                    <a href="#" wire:click.prevent="handleNexPage({{$index + 1}})"  class="text-[#9DA3A8] font-[500] text-base mr-2">Previous Page</a>
                @endif
                <img src="{{asset('/svg/next.svg')}}" alt="next icon"/>
            </div>
        </div>
    </div>
</div>