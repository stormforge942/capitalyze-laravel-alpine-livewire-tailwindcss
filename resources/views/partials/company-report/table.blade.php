<div class="flex justify-between items-center mt-7">
    <div class="warning-wrapper">
        <div class="warning-text text-sm">
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z"
                    fill="#DA680B" />
            </svg>
            Click on any of the row(s) to chart the data
        </div>
    </div>

    <div class="flex justify-end items-baseline">
        <span class="currency-font">Currency: &nbsp;</span>
        <select wire:model="currency" id="currency-select" class="inline-flex font-bold !pr-8 bg-transparent">
            <option value="USD">USD</option>
            <option value="CAD">CAD</option>
            <option value="EUR">EUR</option>
        </select>
    </div>
</div>

<div class="w-full table-container">
    <div class="table-wrapper w-full" style="font-size: 12px;">
        <div class="table" wire:key="{{ now() }}">
            <div class="row-group">
                <div class="flex flex-row bg-gray-custom-light">
                    <div class="ml-8 w-[250px] font-bold flex py-2 items-center justify-start text-base">
                        <span>
                            {{ $company['name'] }} ({{ $company['ticker'] }})
                        </span>
                    </div>
                    <div class="w-full flex flex-row bg-gray-custom-light justify-between">
                        @foreach ($reverse ? array_reverse($tableDates) : $tableDates as $date)
                            <div class="w-[150px] flex items-center justify-center text-base font-bold">
                                <span class="py-2">
                                    {{ date('M Y', strtotime($date)) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($rows)
                    <div class="divide-y text-base" wire:ignore>
                        <div x-data="{ items: $wire.rows }">
                            <template x-for="(item, index) in Object.entries(items)" :key="index">
                                <div x-data="{ value: item[1] }" x-init="loadChildren">
                                    <div class="flex flex-col flex-col-border-less">
                                        <div class="flex w-full flex-row hover:bg-gray-light"
                                            :class="[value.isChecked ? 'bg-[#52D3A2]/20' : (value.segmentation ?
                                                'bg-[#52C6FF]/10' : 'bg-white')]">
                                            <div class="flex justify-center items-center ml-2" wire:ignore>
                                                <input x-show="value.isChecked" type="checkbox" wire:click.stop="select"
                                                    :checked="value.isChecked" name="selected-chart">
                                            </div>
                                            <div wire:click.stop="select"
                                                class="cursor-default py-2  w-[250px] truncate flex flex-row items-center"
                                                :class="value.isChecked ? 'ml-2' : 'ml-6'" style="">
                                                <span
                                                    @click="value.isChecked = true; $wire.emit('selectRow', value.title, value.values)"
                                                    x-text="value.title"
                                                    class="whitespace-nowrap truncate text-base cursor-pointer">
                                                </span>
                                            </div>
                                            <div class="w-full flex flex-row justify-between ">
                                                <template x-for="(val, vi) in Object.entries(value.values)"
                                                    :key="vi">
                                                    <div x-data="{ stat: val[1] }"
                                                        class="w-[150px] flex items-center justify-center text-base">
                                                        <span x-text="stat.value"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <div x-ref="nestedTable"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="cus-loader" wire:loading.block>
        <div class="cus-loaderBar"></div>
    </div>
</div>


@push('scripts')
    <script>
        function loadChildren() {
            const nestedTable = this.$refs.nestedTable;
            const template = `
                <template x-for="(item, index) in value.children">
                    <div x-data="{ value: item}"  x-init="loadChildren">
                        <div class="flex flex-col flex-col-border-less">
                            <div class="flex w-full flex-row hover:bg-gray-light"
                                :class="[value.isChecked ? 'bg-[#52D3A2]/20' : (value.segmentation ? 'bg-[#52C6FF]/10' : 'bg-white')]">
                                <div class="flex justify-center items-center ml-2" wire:ignore>
                                    <input x-show="value.isChecked" type="checkbox" wire:click.stop="select"
                                        :checked="value.isChecked" name="selected-chart">
                                </div>
                                <div wire:click.stop="select"
                                    class="cursor-default py-2  w-[250px] truncate flex flex-row items-center"
                                    :class="value.isChecked ? 'ml-2' : 'ml-6'" style="">
                                    <span @click="value.isChecked = true; $wire.emit('selectRow', value.title, value.values)"
                                        x-text="value.title" class="whitespace-nowrap truncate text-base cursor-pointer">

                                    </span>

                                </div>
                                <div class="w-full flex flex-row justify-between ">
                                    <template x-for="(val, vi) in Object.entries(value.values)" :key="vi">
                                        <div x-data="{stat: val[1]}"
                                            class="w-[150px] flex items-center justify-center text-base">
                                            <span x-text="stat.value"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div x-ref="nestedTable"></div>

                        </div>
                </template>
                `
            nestedTable.innerHTML = template;
            Alpine.initTree(nestedTable);
        }
    </script>
@endpush
