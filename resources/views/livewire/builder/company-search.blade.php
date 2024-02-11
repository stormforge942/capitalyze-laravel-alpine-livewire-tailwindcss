<div class="bg-white p-6 rounded-lg border-[0.5px] border-[#D4DDD7]" x-data="{
    search: $wire.entangle('search'),
    companies: $wire.companies,
}" >
    <label class="font-medium">Search for Companies</label><br>
    <x-dropdown placement="bottom-start" :fullWidthTrigger="true">
        <x-slot name="trigger">
            <input type="search"
                class="text-basde mt-4 p-4 block w-full border border-[#D4DDD7] rounded-lg placeholder:text-gray-medium2 focus:ring-0 focus:border-green-dark"
                placeholder="Company" x-model.debounce.500ms="search">
        </x-slot>

        <div class="w-[20rem] sm:w-[26rem]">
            <div class="flex justify-between gap-2 px-6 pt-6">
                <span class="font-medium text-base">Select Company</span>

                <button @click="dropdown.hide()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                            fill="#686868" />
                    </svg>
                </button>
            </div>

            <div class="p-4" x-text="JSON.stringify(companies)">
            </div>
        </div>
    </x-dropdown>
</div>
