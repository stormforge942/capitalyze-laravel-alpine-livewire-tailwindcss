<div>
<livewire:company-report-navbar :navbar="$navbar" :activeIndex="$activeIndex" :activeSubIndex="$activeSubIndex" />
<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Full Report - {{ Str::title($period) }}</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div class="align-middle">
                    <div class="inline-block min-w-full sm:rounded-lg">
                        {!! $table !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
