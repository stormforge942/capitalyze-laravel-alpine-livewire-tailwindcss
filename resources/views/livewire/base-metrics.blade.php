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
    <div class="py-12">
        <div class="mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded max-w-5xl mx-auto">
                <div class="sm:flex sm:items-start flex-col">
                    <div class="block mb-3">
                        <h1 class="text-base font-semibold leading-10 text-gray-900">{{ $title }}</h1>
                    </div>
                    <div class="grid gap-4 w-full grid-cols-1 md:grid-cols-2 items-start">
                        <div wire:loading.flex class="justify-center items-center min-w-full col-span-2">
                            <div class="grid place-content-center h-full " role="status">
                                <svg aria-hidden="true"
                                    class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                        </div>
                    </div>
                    <div class="mt-8 flow-root rounded-lg overflow-x-auto w-full" wire:loading.remove>
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
