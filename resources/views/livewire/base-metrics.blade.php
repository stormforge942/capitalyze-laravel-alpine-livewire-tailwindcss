<div class="p-4 sm:ml-64 pl-0" x-data="{
    parentTab: $wire.activeIndex,
    childTab: $wire.activeSubIndex,
    shownMessages: [],
    get table() {
        return $wire.tables[this.childTab];
    },
    openSlide(data) {
        window.livewire.emit('slide-over.open', 'international-report-slide', data, {
            force: true
        });
    },
    showMessage() {
        if (!this.table.message || this.shownMessages.includes(this.childTab)) {
            return;
        }

        this.shownMessages.push(this.childTab);

        $dispatch('openinfomodal', {
            html: this.table.message
        })
    },
    init() {
        this.showMessage();
        $watch('childTab', () => this.showMessage());
    }
}">
    @include('partials.international-report-navbar')
    <div class="py-8">
        <div class="mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded max-w-5xl mx-auto">
                <div class="sm:flex sm:items-start flex-col">
                    <div class="block mb-3">
                        <h1 class="text-base font-semibold leading-10 text-gray-900">{{ $title }}</h1>
                    </div>
                    <div class="flow-root rounded-lg overflow-x-auto w-full">
                        <div class="align-middle">
                            <div class="inline-block min-w-full sm:rounded-lg">
                                <table class="table-auto min-w-full data-alt border-collapse">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                                Date
                                            </th>
                                            <template x-for="(_, date) in table.metrics" :key="date">
                                                <th scope="col"
                                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-slate-950 bg-blue-300"
                                                    x-text="date">
                                                </th>
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y bg-white">
                                        <template x-for="(entry, idx) in Object.entries(table.segments)"
                                            :key="entry[0]">
                                            <tr class="border dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                :data-segment-id="idx % 2"
                                                :class="{
                                                    'border-slate-50 bg-cyan-50 hover:bg-blue-200': idx % 2 ==
                                                        0,
                                                    'bg-white border-slate-100 dark:border-slate-400 hover:bg-blue-200': idx %
                                                        2 != 0
                                                }">

                                                <td class="break-words max-w-[150px] lg:max-w-[400px] px-2 py-2 text-sm text-gray-900 font-bold"
                                                    x-text="entry[1]">
                                                </td>

                                                <template x-for="(value, date) in table.metrics" :key="date">
                                                    <template x-if="table.metrics[date][`${entry[0]}`]">
                                                        <td @click="openSlide(value[entry[0]]?.data || {})"
                                                            class="whitespace-nowrap px-2 py-2 text-sm text-gray-900 hover:cursor-pointer hover:underline underline-offset-1"
                                                            x-text="value[entry[0]]?.value || ''">
                                                        </td>
                                                    </template>
                                                    <template x-if="!table.metrics[date][`${entry[0]}`]">
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                        </td>
                                                    </template>
                                                </template>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
