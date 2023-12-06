<div x-data="{
    scrollToHead() {
        $el?.parentElement?.parentElement?.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
}">
    @includeIf(data_get($setUp, 'footer.includeViewOnTop'))
    <div @class([
        'justify-between' => data_get($setUp, 'footer.perPage'),
        'justify-end'  => blank(data_get($setUp, 'footer.perPage')),
        'flex flex-col md:flex-row w-full items-center py-2 bg-white rounded overflow-y-auto pl-2 pr-2 relative
         dark:bg-pg-primary-700' => blank(data_get($setUp, 'footer.pagination')),
])>
        @if(data_get($setUp, 'footer.perPage') && count(data_get($setUp, 'footer.perPageValues')) > 1 && blank(data_get($setUp, 'footer.pagination')))
            <div class="flex flex-row justify-center mb-2 md:justify-start md:mb-0">
                <div class="relative h-10">
                    <select wire:model.lazy="setUp.footer.perPage" @change="scrollToHead()"
                            class="block h-full px-3 py-2 pr-8 leading-tight border rounded bg-pg-primary-50 border-pg-primary-300 text-pg-primary-700 focus:outline-none focus:bg-white focus:border-pg-primary-500 dark:bg-pg-primary-600 dark:text-pg-primary-200 dark:placeholder-pg-primary-100 dark:border-pg-primary-500">
                        @foreach(data_get($setUp, 'footer.perPageValues') as $value)
                            <option value="{{$value}}">
                                @if($value == 0)
                                    {{ trans('livewire-powergrid::datatable.labels.all') }}
                                @else
                                    {{ $value }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="hidden w-full pl-4 sm:block md:block lg:block"
                     style="padding-top: 6px;">
                </div>
            </div>
        @endif

        @if(filled($data))
            <div>
                @if(method_exists($data, 'links'))
                    {!! $data->links(data_get($setUp, 'footer.pagination') ?: powerGridThemeRoot().'.pagination', [
                            'recordCount' => data_get($setUp, 'footer.recordCount'),
                            'perPage' => data_get($setUp, 'footer.perPage'),
                            'perPageValues' => data_get($setUp, 'footer.perPageValues'),
                        ])
                    !!}
                @endif
            </div>
        @endif
    </div>
    @includeIf(data_get($setUp, 'footer.includeViewOnBottom'))
</div>

