<div class="mt-4 relative">
    <div class="rounded-lg sticky-table-container">
        <table class="rounded-lg overflow-clip w-full text-right">
            <thead>
                <tr class="capitalize text-dark bg-[#EDEDED] text-base font-bold">
                    <th class="pl-6 py-2 bg-[#EDEDED] text-left">Name</th>
                    <th class="py-2">Year</th>
                    <th class="py-2 pr-6">Shares</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white">
                    <td class="pl-6 py-2 text-left font-bold">
                    </td>
                    <td class="bg-white" colspan="7">
                        <div>
                            <button type="button"
                                class="inline-block px-2 mr-4 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded"
                                @click="Livewire.emit('slide-over.open', 's3-link-html-content', { url: data.s3_url, sourceLink: data.url, quantity: data.ownership[0]?.shares})">Show
                                Report</button>
                        </div>
                    </td>
                </tr>
                <template x-for="row in data.ownership">
                    <tr class="bg-[#e4eff3]">
                        <td class="pl-6 py-2 text-left">
                            <span class="pl-3" x-text="row.name"></span>
                        </td>
                        <td class="py-2 text-right">
                            <span x-text="year"></p>
                        </td>
                        <td class="py-2 pr-6 text-right">
                            <span x-text="window.formatDecimalNumber(row.shares)"></span>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
