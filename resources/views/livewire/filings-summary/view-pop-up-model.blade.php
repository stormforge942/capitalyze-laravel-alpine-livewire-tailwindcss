<div x-data="{
        indexCount: 0,
        documentCount: 1,
        zoom: 100, 
        rotation: 0,
        nextDocument: @js($index) ?? 1,
        scrollDown(val) { 
            let modalContent = document.getElementById('modal-content');
            let tables = modalContent.getElementsByTagName('table');
            this.documentCount = tables.length;
            
            if(val === 'increment' && this.indexCount < this.documentCount ){
                this.indexCount++;
            }
            else if(val === 'decrement' && this.indexCount > 0){
                this.indexCount--;
            }
            let index = this.indexCount ;
            let scrollTop = 0;
            let table = tables[index];
            // Calculate the total height of previous tables
            let prevTablesHeight = 0;
            for (let j = 0; j < index; j++) {
                prevTablesHeight += tables[j].offsetHeight;
            }

            // Scroll to the position of the current table
            modalContent.scrollTop = prevTablesHeight;
            scrollTop += table.offsetHeight;
        },
    }" 
    @click.outside="open=true" 
    class="text-left bg-white rounded-lg overflow-hidden shadow-xl sm:w-[100%] md:w-[60%]" 
    @click.away="open = false"
>
    <div class=" bg-[#fff] p-3">
        <div class="cus-loader" wire:loading.block style="top:  7.80rem !important; left: 24% !important;
    width: 54% !important;">
            <div class="cus-loaderBar"></div>
        </div>
        <div class="flex justify-between items-center content-center">
            <div>
                <select wire:model="form_type" wire:change="handleFormType" class="rounded-lg border-2 border-[#D1D3D5] ring-1 ring-[#D1D3D5] outline-[#D1D3D5] p-2">
                    @foreach($rows as $row)
                        <option value="{{$row->form_type ?? $row['form_type']}}">From {{$row->form_type ?? $row['form_type']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-between items-center">
                <img class="mr-3 cursor-pointer" @click="zoom -= 10" src="{{asset('/svg/zoom-out.svg')}}" alt="zoom out"/>
                <img class="mr-3 cursor-pointer" @click="zoom += 10" src="{{asset('/svg/zoom-in.svg')}}" alt="zoom in"/>
                <img class="mr-3 cursor-pointer" @click="rotation += 45" src="{{asset('/svg/rotate.svg')}}" alt="rotate"/>
                <img class="mr-3 cursor-pointer" @click="$wire.closePopUp(); open = false" src="{{asset('/svg/close-cross-circle.svg')}}" alt="close cross circle"/>
            </div>
        </div>
    </div>    
    <div class="content bg-[#D1D3D5] p-0.5">
        <div class="flex flex-col bg-[#fff] my-0 mx-5 h-[30rem] overflow-y-auto px-2">
            <div 
                id="modal-content" 
                class="flex flex-col divide-solid"
                :style="'transform: scale(' + zoom/100 + ') rotate(' + rotation + 'deg); max-height: 90%; overflow-y: auto;'"
            >
                {!! $s3_link !!}
            </div>
        </div>
    </div>
    <div class="footer bg-[#fff] p-3 ">
        <div class="flex justify-between items-center">
            <div class="flex justify-start items-center content-center">
                <img src="{{asset('/svg/previous.svg')}}" alt="prvious icon"/>
                <a href="#" @click.prevent="scrollDown('decrement')" :class="`${indexCount === 0 ? 'disabled text-[#9DA3A8]' : ''}`" class=" text-[#2C71F0] text-base font-[500] ml-1">Previous Page</a>
            </div>
            <h4 class="text-base font-[600] text-[#01090F]" x-text="`Page ${indexCount}  of ${documentCount }`"></h4>
            <div class="flex justify-start items-center content-center">
                <a href="#" @click.prevent="scrollDown('increment')" :class="`${indexCount === documentCount ? 'disabled text-[#9DA3A8]' : ''}`" class="text-[#2C71F0] font-[500] text-base mr-2">Next Page</a>
                <img src="{{asset('/svg/next.svg')}}" alt="next icon"/>
            </div>
        </div>
    </div>
</div>