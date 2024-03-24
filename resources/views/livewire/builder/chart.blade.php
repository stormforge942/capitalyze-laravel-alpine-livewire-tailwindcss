<div class="chart-builder-page">
    <div>
        <h1 class="text-xl font-bold">Chart</h1>
        <p class="mt-2 text-dark-light2">Build custom charts to visualize financial data across companies</p>
    </div>

    <div class="mt-8">
        @livewire('builder.chart-tabs')
    </div>

    @if ($tab)
        <div>
            <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div>
                    <livewire:builder.select-company :selected="$tab['companies']" />
                </div>

                <div>
                    <livewire:builder.select-chart-metrics :selected="$tab['metrics']" />
                </div>
            </div>

            <div class="mt-6">
                @livewire('builder.chart-filters')
            </div>
        </div>
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
