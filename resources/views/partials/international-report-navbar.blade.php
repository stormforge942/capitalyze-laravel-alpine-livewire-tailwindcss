<div>
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px">
                <template x-for="tab in $wire.navbar" :key="tab.id">
                    <li class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="tab.id == parentTab ? 'text-blue-600 active border-blue-600' :
                            'cursor-pointer border-transparent hover:text-gray-600 hover:border-gray-300'"
                        @click="parentTab = tab.id" x-text="tab.title">
                    </li>
                </template>
            </ul>
        </div>
    </div>
    <div class="relative px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <div class="flex items-center">
                <div class="overflow-x-scroll scrollbar-hide px-1">
                    <ul class="flex flex-nowrap -mb-px">
                        <template x-for="tab in $wire.navbar[parentTab].child" :key="tab.id">
                            <li :data-tab-id="tab.id"
                                class="inline-block whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg"
                                :class="tab.id == childTab ? 'text-blue-600 active border-blue-600' :
                                    'cursor-pointer border-transparent hover:text-gray-600 hover:border-gray-300'"
                                @click="childTab = tab.id" x-text="tab.title">
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
