<form class="px-1 flex flex-col xl:flex-row items-center gap-8" @submit.prevent="">
    <div
        class="w-full xl:w-auto grid grid-cols-3 xl:flex items-center gap-5 xl:gap-3 2xl:gap-5 text-sm text-gray-medium2">
        <?php
        $ranges = ['3m' => '3m', '6m' => '6m', 'YTD' => 'YTD', '1yr' => '1yr', '5yr' => '5yr', 'max' => 'MAX'];
        ?>
        @foreach ($ranges as $value => $label)
            <label class="cursor-pointer flex items-center gap-x-1">
                <input type="radio" name="company-overview-chart-period" value="{{ $value }}"
                    class="custom-radio focus:ring-0 border-gray-medium2" x-model="currentChartPeriod">
                <span :class="currentChartPeriod === '{{ $value }}' ? 'text-dark' : ''">{{ $label }}</span>
            </label>
        @endforeach
    </div>
</form>
