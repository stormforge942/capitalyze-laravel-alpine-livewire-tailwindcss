<x-wire-elements-pro::tailwind.slide-over>
    <x-slot name="title" class="font-bold">{!! $title !!}</x-slot>

    @if($loaded == false)
        <div class="grid place-content-center h-full" role="status" wire:init="loadData">
            <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    @else
       @if($data !== null)
            @if(array_key_exists('Standardized Metrics Match', $data))
            <p class="text-lg font-bold">Standardized Metrics Match</p>
            <table class="table-auto border-collapse">
                <thead>
                    <tr>
                        <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                            Original metric
                        </th>
                        <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                            Standardized metric
                        </th>
                        <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                            Period
                        </th>
                        <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                            Section
                        </th>
                        <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                            Type
                        </th>
                        <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                            Match Code
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['Standardized Metrics Match'] as $key => $value)
                        <tr>
                        <td class="break-all border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                        {!! $data['Standardized Metrics Match'][$key][0] !!}
                        </td>
                        <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                        {!! $data['Standardized Metrics Match'][$key][3] !!}
                        </td>
                        <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                        {!! $period !!}
                        </td>
                        <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                        {!! $data['Standardized Metrics Match'][$key][2] !!}
                        </td>
                        <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                        {!! $data['Standardized Metrics Match'][$key][1] !!}
                        </td>
                        <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                        {!! $data['Standardized Metrics Match'][$key][5] !!}
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if(array_key_exists('Pairing', $data))
                <p class="text-base font-bold mt-5">Paired QNames for {!! $data['Standardized Metrics Match'][0][0] !!}</p>
                <table class="table-auto border-collapse w-full mt-2">
                    <tbody>
                        @foreach($data['Pairing'] as $key => $value)
                            <tr>
                                <td class="border break-all border-slate-600 px-2 py-2 text-left text-sm font-medium text-gray-900">
                                    {!! $value[0] !!}
                                </td>
                                <td class="border break-all border-slate-600 px-2 py-2 text-left text-sm font-medium text-gray-900">
                                    {!! $value[1] !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if(array_key_exists('Labels', $data))
                @foreach($data['Labels'] as $item => $arr)
                    <p class="text-base font-bold mt-5">Labels for {!! $item !!} </p>
                    @foreach($arr as $key => $value)
                        @if($value[1] == 'documentation')
                            <p class="text-sm italic mt-1">{!! $value[0] !!}</p>
                        @endif
                    @endforeach
                    <table class="table-auto border-collapse w-full mt-2">
                        <tbody>
                            @foreach($arr as $key => $value)
                                @if($value[1] !== 'documentation')
                                <tr>
                                    <td class="border border-slate-600 px-2 py-2 text-left text-sm font-medium text-gray-900">
                                            {!! $value[0] !!} 
                                    </td>
                                    <td class="border border-slate-600 px-2 py-2 text-left text-sm font-medium text-gray-900">
                                            {!! $value[1] !!} 
                                    </td>
                                    <td class="border border-slate-600 px-2 py-2 text-left text-sm font-medium text-gray-900">
                                            {!! $value[2] !!}
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endif
            @if(array_key_exists('Corrections', $data))
                <p class="text-lg font-bold mt-5">Corrections</p>
                <table class="table-auto border-collapse mt-2">
                    <thead>
                        <tr>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Metrics
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Period
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Restated on
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Restated value
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Originally reported date
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Originally reported value	
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Correction value
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['Corrections'] as $key => $value)
                            <tr>
                            <td class="break-all border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Corrections'][$key][1] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Corrections'][$key][2] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $period !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Corrections'][$key][4] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Corrections'][$key][6] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Corrections'][$key][3] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Corrections'][$key][5] !!}
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if(array_key_exists('Restatements', $data))
                <p class="text-lg font-bold mt-5">Restatements</p>
                <table class="table-auto border-collapse mt-2">
                    <thead>
                        <tr>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Metrics
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Period
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Restated on
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Restated value
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Originally reported date
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Originally reported value	
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Correction value
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['Restatements'] as $key => $value)
                            <tr>
                            <td class="break-all border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Restatements'][$key][1] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Restatements'][$key][2] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $period !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Restatements'][$key][4] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Restatements'][$key][6] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Restatements'][$key][3] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Restatements'][$key][5] !!}
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if(array_key_exists('Formula Processing Log', $data))
                <p class="text-lg font-bold mt-5">Formula Processing Log</p>
                <table class="table-auto border-collapse mt-2">
                    <thead>
                        <tr>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Standardized Metrics
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Section
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Type
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Period
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Event type
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Original value
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Calculated value
                            </th>
                            <th scope="col" class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                Formula Id
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['Formula Processing Log'] as $key => $value)
                            <tr>
                            <td class="break-all border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][0] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][1] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][2] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][3] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][4] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][5] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            {!! $data['Formula Processing Log'][$key][6] !!}
                            </td>
                            <td class="border border-slate-600 px-2 py-2 text-left text-sm font-semibold text-gray-900">
                            
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
        <h1>No data available</h1>
        @endif
    @endif
</x-wire-elements-pro::tailwind.slide-over>