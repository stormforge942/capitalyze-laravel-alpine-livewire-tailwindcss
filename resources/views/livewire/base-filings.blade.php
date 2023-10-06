<div class="p-4 sm:ml-64 pl-0">
    <div class="py-12">
        <div class="mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded max-w-5xl mx-auto">
                <div class="sm:flex sm:items-start flex-col">
                    <div class="block mb-3">
                        <h1 class="text-base font-semibold leading-10 text-gray-900">{{ $title }}</h1>
                    </div>
                    <div class="flow-root rounded-lg overflow-x-auto w-full" wire:loading.remove>
                        <div class="align-middle">
                            <div class="inline-block min-w-full sm:rounded-lg">
                                <livewire:is :component="$table" :model="$model" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>