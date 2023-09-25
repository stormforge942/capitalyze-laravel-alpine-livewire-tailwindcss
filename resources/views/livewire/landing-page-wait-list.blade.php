<div class="h-full min-h-screen bg-white wait-list absolute w-full overflow-x-hidden">
    <div class="w-full absolute flex {{$completed ? 'justify-center' : 'justify-start'}} sm:justify-center lg:justify-start px-6 sm:px-16 top-10">
        <div class="w-[123px] h-[27px] sm:w-[200px] sm:h-[45px]">
            {{ Html::image('img/logo.png', 'features') }}
        </div>
    </div>
    <div class="w-full absolute flex justify-end items-end px-6 sm:px-16 top-10">
        <button style="background: #52D3A2;" class="w-[160px] h-[40px] rounded font-bold hidden sm:block">
            Sign in
        </button>
        <div style="color: #121A0F;" class="text-sm sm:text-base font-bold {{$completed ? 'hidden' : 'block'}} sm:hidden whitespace-nowrap mt-1 sm:mt-3">
            Have an account? Sign In
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 mx-8 sm:mx-16 z-30 mt-16">
        <div>
            <div class="w-full justify-end hidden lg:flex">
                <div style="width: 92px; height: 68px;" class="">
                    {{ Html::image('img/check-blank.png', 'features') }}
                </div>
            </div>

            <div class="mt-20">
                <h1 class="whitespace-nowrap text-3xl sm:text-4xl md:text-5xl font-semibold break-words text-center sm:text-start">
                    The future of financial data
                </h1>
                <p class="text-gray-900 text-lg sm:text-2xl font-normal mt-4 text-center sm:text-start">
                    Uncover fundamental insights to capitalize on opportunities. Analyze global financial data, revenue, cost structure, capital allocation, and more.
                </p>
                <p class="mt-6 text-xs sm:text-xl text-center lg:text-start">
                    Exciting things you can do with
                    <b>Capitalyze</b> in the beta program
                </p>
                <div class="mt-4 flex flex-col sm:flex-row justify-center lg:justify-start space-x-2 space-y-3 sm:space-y-0">
                    <div class="flex flex-row space-x-2 w-full sm:w-auto justify-center lg:justify-start">
                        <div class="wait-list-button-text text-sm sm:text-base px-3 sm:px-6 py-2 bg-black w-min rounded font-semibold">
                            Financials
                        </div>
                        <div class="wait-list-button-text text-sm sm:text-base px-3 sm:px-6 py-2 bg-black w-min rounded font-semibold">
                            Analysis
                        </div>
                        <div class="wait-list-button-text text-sm sm:text-base px-3 sm:px-6 py-2 bg-black w-min rounded font-semibold">
                            Analysis
                        </div>
                        <div class="wait-list-button-text text-sm sm:text-base px-3 sm:px-6 py-2 bg-black w-min rounded font-semibold">
                            Financials
                        </div>
                    </div>
                    <div class="w-full text-center text-sm sm:text-base px-2 sm:px-4 py-2 whitespace-nowrap sm:w-min rounded font-semibold">
                        <span>and more...</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="w-full flex flex-row">

                @if(!$completed)
                <div class="mt-12 sm:mt-36 shadow rounded flex flex-col w-full lg:w-8/12 lg:ml-12 px-4 sm:mx-32 lg:mx-0 py-6">
                    <div class="text-4xl w-full text-center font-semibold">
                        Join the waitlist
                    </div>
                    <div class="py-4 w-full flex justify-center">
                        <div class="rounded-full w-min uppercase bg-opacity-80 whitespace-nowrap px-2 text-xs font-semibold"
                             style="
                                border-radius: 123px;
                                border: 1px solid #B3D7CE;
                                background: #F2FBF2;
                            "
                        >
                            beta launch
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="rounded-md px-3 shadow-sm border">
                                <label for="name" class="block text-base font-medium text-gray-600 ml-3 pt-1 pb-0">Name</label>
                                <input type="text" name="name" id="name" class="block w-full border-0 pb-1 text-gray-900 pt-0 text-base focus:outline-none focus:ring-0" placeholder="Jane Smith">
                            </div>
                        </div>
                        <div>
                            <div class="rounded-md px-3 shadow-sm border">
                                <label for="name" class="block text-base font-medium text-gray-600 ml-3 pt-1 pb-0">Work email</label>
                                <input type="text" name="name" id="name" class="block w-full border-0 pb-1 text-gray-900 pt-0 text-base focus:outline-none focus:ring-0" placeholder="sahil@capitalyze.com">
                            </div>
                        </div>
                        <div>
                            <div class="rounded-md px-3 shadow-sm border">
                                <label for="name" class="block text-base font-medium text-gray-600 ml-3 pt-1 pb-0">LikedIn</label>
                                <input type="text" name="name" id="name" class="block w-full border-0 pb-1 text-gray-900 pt-0 text-base focus:outline-none focus:ring-0" placeholder="linkedin.com/sah">
                            </div>
                            <p class="text-red-600 text-sm font-normal leading-4 ml-4 mt-1">Please enter a valid linkedin profile link</p>
                        </div>
                    </div>
                    <button wire:click="submit" style="background: #52D3A2;" class="w-full py-2 rounded font-bold mt-6">
                        Get early access
                    </button>
                </div>

                @else
                    <div class="mt-12 sm:mt-36 shadow rounded flex flex-col w-full sm:w-8/12 px-4 py-6">
                        <div class="text-2xl sm:text-4xl w-full text-center font-semibold whitespace-nowrap">
                            Thanks for joining the waitlist
                        </div>
                        <p class="my-4 text-lg w-full text-center">
                            You’ll be the first to know once we launch
                        </p>
                        <div class="w-full flex justify-center">
                            {{ Html::image('img/check.png', 'features') }}
                        </div>
                    </div>
                @endif


                <div class="mt-24 ml-10 hidden lg:block">
                    {{ Html::image('img/blank.png', 'features') }}
                </div>
            </div>
        </div>
    </div>
    <div class="left-16 relative" style="{{$completed ? 'top: 157px' : ''}}">
        {{ Html::image('img/features.png', 'features') }}
    </div>
</div>
