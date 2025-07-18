<div>
    <div>
        <livewire:company-navbar :company="$company ?? ['ticker' => 'aapl']" />
        <!-- Page Content Begin -->
        <main>
            <div class="p-4 sm:ml-64 pl-0">
                
                <div class="py-2">
                    <div class="mx-auto flex flex-col md:flex-row justify-center">
                        <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-8 rounded md:w-12/14 2xl:w-2/3 w-full">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto text-center">
                                    <h1 class="text-xl font-bold leading-10 text-gray-900">Economic Release</h1>
                                </div>
                            </div>
                            <div wire:loading.flex class="justify-center items-center">
                                    <div class="grid place-content-center h-full" role="status">
                                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="overflow-x-scroll">
                                <table class="table-auto w-full overflow-scroll" wire:loading.remove>
                                        <tr>
                                            <td class="font-semibold py-4">Title</td>
                                            <td class="font-semibold py-4">Observation</td>
                                            <td class="font-semibold py-4">Seasonal Adjustment</td>
                                            <td class="font-semibold py-4">Popularity</td>
                                            <td class="font-semibold py-4">Last Updated</td>
                                        </tr>
                                        @foreach($economicRelease as $release)
                                        <tr>
                                            <td class="break-all px-2"><a href="{{ route('economics-release-series', ['release_id' => $release->release_id, 'series_id' => $release->series_id]) }}">{{ $release->title }}</a></td>
                                            <td class="break-all px-2">from {{ $release->observation_start }} to {{ $release->observation_end }}</td>
                                            <td class="break-all px-2">{{ $release->seasonal_adjustment }}</td>
                                            <td class="break-all px-2">{{ $release->popularity }}</td>
                                            <td class="px-2">{{ $release->last_updated }}</td>
                                        </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Page Content End -->
    </div>
</div>
