<x-wire-elements-pro::tailwind.slide-over>
    <x-slot name="title" class="font-bold">{!! $title !!}</x-slot>

    @if(array_key_exists('Standardized Metrics Match', $data))
    <p class="text-lg font-bold">Standardized Metrics Match</h3>
    <table class="table-auto border-collapse">
        <thead>
            <tr>
                <th scope="col" class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">
                    Original metric
                </th>
                <th scope="col" class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">
                    Standardized metric
                </th>
                <th scope="col" class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">
                    Period
                </th>
                <th scope="col" class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">
                    Section
                </th>
                <th scope="col" class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">
                    Type
                </th>
                <th scope="col" class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">
                    Match Code
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['Standardized Metrics Match'] as $key => $value)
                <tr>
                <td class="break-all border border-slate-600 px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                {!! $data['Standardized Metrics Match'][$key][0] !!}
                </td>
                <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                {!! $data['Standardized Metrics Match'][$key][3] !!}
                </td>
                <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                {!! $period !!}
                </td>
                <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                {!! $data['Standardized Metrics Match'][$key][2] !!}
                </td>
                <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                {!! $data['Standardized Metrics Match'][$key][1] !!}
                </td>
                <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
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
                        <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-medium text-gray-900">
                            {!! $value[0] !!}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-medium text-gray-900">
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
                            <td class="border border-slate-600 px-2 py-3.5 text-left text-sm font-medium text-gray-900">
                                    {!! $value[0] !!} 
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-medium text-gray-900">
                                    {!! $value[1] !!} 
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap px-2 py-3.5 text-left text-sm font-medium text-gray-900">
                                    {!! $value[2] !!}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
</x-wire-elements-pro::tailwind.slide-over>