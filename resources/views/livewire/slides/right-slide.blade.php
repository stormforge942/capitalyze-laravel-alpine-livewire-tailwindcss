<x-wire-elements-pro::tailwind.slide-over>
    <x-slot name="title">{!! $title !!}</x-slot>

    @if (!$loaded)
        <div class="grid place-content-center h-full" role="status" wire:init="loadData">
            <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    @else
        <div>
            <div>
                <h3 class="text-md font-semibold">{{ $result['message'] }}</h3>
                <p class="mt-2 font-medium value_final_raw inline-block">
                    {{ number_format($result['body']['value_final_raw'], $decimalPlaces) }}
                </p>
            </div>

            @if (data_get($result, 'body.formula_evaluation', []))
                <div class="my-3">
                    <p class="font-semibold">Formulas</p>
                    <div class="space-y-3 mt-1">
                        @foreach ($result['body']['formula_evaluation'] as $formula)
                            <div class="space-y-2">
                                <table class="border">
                                    <tr class="border-b">
                                        <td style="vertical-align: top"
                                            class="py-1 pl-3 pr-5 min-w-[150px] font-medium">
                                            Expression</td>
                                        <td style="vertical-align: top" class="py-1">{{ $formula['formula'] }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td style="vertical-align: top"
                                            class="py-1 pl-3 pr-5 min-w-[150px] font-medium">
                                            Resolved</td>
                                        <td style="vertical-align: top" class="py-1">{!! preg_replace('/-(\d+)/', '<span class="text-red-500">($1)</span>', $formula['resolved']) !!}</td>
                                    </tr>
                                    @if (count(data_get($formula, 'arguments', [])))
                                        <tr class="border-b">
                                            <td style="vertical-align: top"
                                                class="py-1 pl-3 pr-5 min-w-[150px] font-medium">
                                                Arguments</td>
                                            <td style="vertical-align: top" class="py-1">
                                                <div class="divide-y -my-2">
                                                    @foreach ($formula['arguments'] as $name => $item)
                                                        @if ($item['hint'])
                                                            <div class="py-2">
                                                                <p class="font-medium">{{ $name }}</p>
                                                                <p class="mt-1"
                                                                    @click="() => {
                                                                    const btns = document.querySelectorAll('.wep-slide-over-container .sub-arg-btn')    

                                                                    setTimeout(() => {
                                                                        btns.forEach(btn => {
                                                                            btn.removeAttribute('disabled')
                                                                        })
                                                                    }, 1000)
                                                                }">
                                                                    {!! $this->transformHint($item['hint'], $item['sub_arguments'], $item['value']) !!}
                                                                </p>
                                                                <p class="inline-block"> =>
                                                                    {{ number_format($item['value'], $decimalPlaces) }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="vertical-align: top"
                                            class="py-1 pl-3 pr-5 min-w-[150px] font-medium">
                                            Result</td>
                                        <td style="vertical-align: top" class="py-1">
                                            <span>
                                                {{ number_format($formula['equals'], $decimalPlaces) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (is_string($data))
                <div x-data="{
                    init() {
                        window.initTableExport(this.$el)
                    }
                }">
                    {!! $data !!}
                </div>
            @endif

            @if (!$data && !$result)
                No data found
            @endif
        </div>
        <script>
            const value = @json($value)

            window.reportTextHighlighter.highlight(value, '.wep-slide-over-container table tbody tr td')
            window.reportTextHighlighter.highlight(value, '.wep-slide-over-container .value_final_raw')
        </script>
    @endif
</x-wire-elements-pro::tailwind.slide-over>
