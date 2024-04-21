<div>
    <div>
        <h1 class="text-xl font-bold">Table</h1>
        <p class="mt-2 text-dark-light2">Build custom table to visualize financial data across companies</p>
    </div>

    <div class="mt-8">
        @livewire('builder.table-tabs')

        <div class="mt-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-2 whitespace-nowrap">
                <div class="bg-white p-2 flex items-center justify-between gap-x-5 rounded-t">
                    <button class="px-4 py-2 flex items-center gap-x-2 font-medium text-sm bg-[#DCF6EC] rounded">
                        Add Ticker
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.33594 7.33398V4.66732H8.66927V7.33398H11.3359V8.66732H8.66927V11.334H7.33594V8.66732H4.66927V7.33398H7.33594ZM8.0026 14.6673C4.3207 14.6673 1.33594 11.6825 1.33594 8.00065C1.33594 4.31875 4.3207 1.33398 8.0026 1.33398C11.6845 1.33398 14.6693 4.31875 14.6693 8.00065C14.6693 11.6825 11.6845 14.6673 8.0026 14.6673ZM8.0026 13.334C10.9481 13.334 13.3359 10.9462 13.3359 8.00065C13.3359 5.05513 10.9481 2.66732 8.0026 2.66732C5.05708 2.66732 2.66927 5.05513 2.66927 8.00065C2.66927 10.9462 5.05708 13.334 8.0026 13.334Z"
                                fill="#121A0F" />
                        </svg>
                    </button>

                    <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white">
                        8 Tickers
                    </div>
                </div>
                <div class="bg-white p-2 flex items-center justify-between gap-x-5 rounded-t">
                    <button class="px-4 py-2 flex items-center gap-x-2 font-medium text-sm bg-[#DCF6EC] rounded">
                        Add Ticker
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.33594 7.33398V4.66732H8.66927V7.33398H11.3359V8.66732H8.66927V11.334H7.33594V8.66732H4.66927V7.33398H7.33594ZM8.0026 14.6673C4.3207 14.6673 1.33594 11.6825 1.33594 8.00065C1.33594 4.31875 4.3207 1.33398 8.0026 1.33398C11.6845 1.33398 14.6693 4.31875 14.6693 8.00065C14.6693 11.6825 11.6845 14.6673 8.0026 14.6673ZM8.0026 13.334C10.9481 13.334 13.3359 10.9462 13.3359 8.00065C13.3359 5.05513 10.9481 2.66732 8.0026 2.66732C5.05708 2.66732 2.66927 5.05513 2.66927 8.00065C2.66927 10.9462 5.05708 13.334 8.0026 13.334Z"
                                fill="#121A0F" />
                        </svg>
                    </button>

                    <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white">
                        8 Metrics
                    </div>
                </div>
                <div class="bg-white p-2 flex items-center justify-between gap-x-5 rounded-t">
                    <button class="px-4 py-2 flex items-center gap-x-2 font-medium text-sm bg-[#DCF6EC] rounded">
                        Add Summary
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.33594 7.33398V4.66732H8.66927V7.33398H11.3359V8.66732H8.66927V11.334H7.33594V8.66732H4.66927V7.33398H7.33594ZM8.0026 14.6673C4.3207 14.6673 1.33594 11.6825 1.33594 8.00065C1.33594 4.31875 4.3207 1.33398 8.0026 1.33398C11.6845 1.33398 14.6693 4.31875 14.6693 8.00065C14.6693 11.6825 11.6845 14.6673 8.0026 14.6673ZM8.0026 13.334C10.9481 13.334 13.3359 10.9462 13.3359 8.00065C13.3359 5.05513 10.9481 2.66732 8.0026 2.66732C5.05708 2.66732 2.66927 5.05513 2.66927 8.00065C2.66927 10.9462 5.05708 13.334 8.0026 13.334Z"
                                fill="#121A0F" />
                        </svg>
                    </button>

                    <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white">
                        0 Summary
                    </div>
                </div>
            </div>
            <div class="mt-0.5 overflow-x-auto rounded-b-lg">
                <table class="overflow-hidden">
                    <tr class="font-bold whitespace-nowrap bg-[#EDEDED]">
                        <td class="py-3 pl-8">Ticker</td>
                        <td class="py-3 pl-6">Name</td>
                        <td class="py-3 pl-6">Sector</td>
                        <td class="py-3 pl-6">Market Cap</td>
                        <td class="py-3 pl-6">Stock Price</td>
                        <td class="py-3 pl-6">Total Return (3M)</td>
                        <td class="py-3 pl-6">Total Revenue</td>
                        <td class="py-3 pl-6 pr-8">Notes</td>
                    </tr>
                    <tr class="bg-white border-y-2 border-gray-light font-semibold">
                        <td class="py-4 pl-8">
                            AAPL
                        </td>
                        <td class="py-4 pl-6">
                            AAPL
                        </td>
                        <td class="py-4 pl-6">
                            AAPL
                        </td>
                        <td class="py-4 pl-6">
                            AAPL
                        </td>
                        <td class="py-4 pl-6">
                            AAPL
                        </td>
                        <td class="py-4 pl-6">
                            AAPL
                        </td>
                        <td class="py-4 pl-6">
                            AAPL
                        </td>
                        <td class="py-4 pl-6 pr-8">
                            AAPL
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
