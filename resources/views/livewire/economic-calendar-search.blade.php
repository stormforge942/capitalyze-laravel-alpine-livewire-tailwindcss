<div class="py-2">
    <div class="mx-auto flex flex-col md:flex-row justify-center">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-8 rounded md:w-12/14 2xl:w-2/3 w-full">
            <div class="relative flex items-center">
                <input type="text" wire:model="search" placeholder="Search Economic Events..." class="input-field pr-10">
                <svg class="absolute right-3 top-2.5 h-5 w-5 text-pg-primary-300 dark:text-pg-primary-200" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            @if($search && $resultsSearch)
                <div class="result-container shadow">
                    <table class="result-box">
                        <thead>
                            <tr>
                                <th class="text-left px-2 py-2">Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultsSearch as $result)
                                <tr class="hover:bg-gray-200 cursor-pointer">
                                    <td class="break-all px-2">
                                        <a 
                                            href="{{ route('economics-release-series', ['release_id' => $result->release_id, 'series_id' => $result->series_id]) }}"
                                        >
                                            {{ $result->title }} | from {{ $result->observation_start }} to {{ $result->observation_end }} | {{ $result->seasonal_adjustment }} | {{ $result->popularity }} | {{ $result->last_updated }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($showText && !$search )
                <div class="result-container shadow">
                    <table class="result-box">
                        <tbody>
                            
                            <tr class="hover:bg-gray-200 cursor-pointer">
                                <td class="text-left px-2 py-2 w-1/4">
                                    Search Economic Events...
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
