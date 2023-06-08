<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Insider table</h1>
                </div>
            </div>
            <livewire:company-insider-table :company="$company" :ticker="$ticker"/>
        </div>
    </div>
</div>
