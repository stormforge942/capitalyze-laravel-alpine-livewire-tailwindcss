<form class="px-1 flex flex-col xl:flex-row items-center gap-8" @submit.prevent="">
    <div class="w-full xl:w-auto grid grid-cols-3 xl:flex items-center gap-5 text-sm text-gray-medium2">
        <template x-for="item in Object.keys(periodOptions)" :key="item">
            <label class="cursor-pointer flex items-center gap-x-1" :data-value="period">
                <input type="radio" name="company-overview-chart-period" :value="item"
                    class="custom-radio focus:ring-0 border-gray-medium2" x-model="period">
                <span class="peer-checked:text-dark" x-text="item"></span>
            </label>
        </template>
    </div>

    <div>
        <x-range-calendar x-model="dateRange" wire:ignore />
    </div>
</form>
