<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Report Metrics - {{ Str::title($period) }}</h1>
                </div>
                <div class="block">
                    <div class="relative mt-3">
                        <label for="faces" class="inline-flex text-sm font-semibold text-gray-900">Metric: </label>
                        <select wire:model="currentFace" wire:key="faces-select"
                            class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                            name="faces" wire:change="$emit('metricChange', $event.target.value, document.querySelector('#faces option:checked').parentElement.label)" id="faces">
                            {!! $faces !!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div class="align-middle">
                    <div class="inline-block min-w-full sm:rounded-lg" wire:model="table">
                        {!! $table !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    let slideOpen = false;

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            var element = event.target;
            if (element.classList.contains('open-slide') && !slideOpen) {
                var value = element.dataset.value;
                var payload = JSON.parse(value);
                window.livewire.emit('slide-over.open', 'company-fact-slide', payload, {force: true});
                slideOpen = true;
                document.body.style.cursor = "progress";
            }
        });
    });

    Livewire.on('slide-over.close', () => {
        slideOpen = false;
    });

    Livewire.on('Slideloaded', () => {
       document.body.style.cursor = "default";
    });
</script>
@endpush