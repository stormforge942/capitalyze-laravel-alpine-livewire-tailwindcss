<div class="divide-y text-base" wire:ignore>
    <div x-data="{ items: @entangle('rows') }">
        <template x-for="(item, index) in Object.entries(items)" :key="index">
            <div class="flex flex-col flex-col-border-less">
                <div class="flex w-full flex-row hover:bg-gray-light"
                    :class="[item[1]?.isChecked ? 'bg-[#52D3A2]/20' : (item[1]?.segmentation ? 'bg-[#52C6FF]/10' : 'bg-white')]">
                    <div class="flex justify-center items-center ml-2" wire:ignore>
                        <input x-show="item[1]?.isChecked" type="checkbox" wire:click.stop="select"
                            :checked="item[1]?.isChecked" name="selected-chart">
                    </div>
                    <div wire:click.stop="select"
                        class="cursor-default py-2  w-[250px] truncate flex flex-row items-center"
                        :class="item[1]?.isChecked ? 'ml-2' : 'ml-6'" style="">
                        <span
                            @click="item[1].isChecked = true; $wire.emit('selectRow', item[1]?.title, item[1]?.values)"
                            x-text="item[1]?.title" class="whitespace-nowrap truncate text-base cursor-pointer">
                        </span>
                    </div>
                    <div class="w-full flex flex-row justify-between ">
                        <template x-for="(val, vi) in Object.entries(item[1]?.values)" :key="vi">
                            <div x-data="{ stat: val[1] }" class="w-[150px] flex items-center justify-center text-base">
                                <span x-text="stat.value"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <div x-ref="nestedTable"></div>

            </div>
        </template>
    </div>
</div>

@push('scripts')
    <script>
        function loadChildren() {
            try {
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
            } catch (ex) {

            }
        }
    </script>
@endpush
