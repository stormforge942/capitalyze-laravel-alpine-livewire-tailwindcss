<div class="w-full  text-left bg-white rounded-lg overflow-hidden shadow-xl md:max-w-xl" @click.away="open = false">
    <div class=" bg-[#fff] p-3">
        <div class="flex justify-between items-center content-center">
            <div>
                <select class="rounded-lg border-2 border-[#D1D3D5] ring-1 ring-[#D1D3D5] outline-[#D1D3D5] p-2">
                    <option>From 10-k.pdf</option>
                </select>
            </div>
            <div class="flex justify-between items-center">
                <img class="mr-3" src="{{url('/svg/zoom-out.svg')}}" alt="zoom out"/>
                <img class="mr-3" src="{{url('/svg/zoom-in.svg')}}" alt="zoom in"/>
                <img class="mr-3" src="{{url('/svg/rotate.svg')}}" alt="rotate"/>
                <img class="mr-3 cursor-pointer" @click="open = false" src="{{url('/svg/close-cross-circle.svg')}}" alt="close cross circle"/>
            </div>
        </div>
    </div>    
    <div class="content bg-[#D1D3D5] p-0.5">
        <div class="flex flex-col bg-[#fff] my-0 mx-5 h-[30rem]">
            <div class="flex flex-col divide-solid">
                <h4>Image area</h4>
            </div>
        </div>

    </div>
    <div class="footer bg-[#fff] p-3 ">
        <div class="flex justify-between items-center">
            <div class="flex justify-start items-center content-center">
                <img src="{{url('/svg/previous.svg')}}" alt="prvious icon"/>
                <a href="#" class="text-[#9DA3A8] text-base font-[500] ml-1">Previous Page</a>
            </div>
            <h4 class="text-base font-[600] text-[#01090F]">Page 1 of 5</h4>
            <div class="flex justify-start items-center content-center">
                <a href="#" class="text-[#2C71F0] font-[500] text-base mr-2">Next Page</a>
                <img src="{{url('/svg/next.svg')}}" alt="next icon"/>
            </div>
        </div>
    </div>
</div>