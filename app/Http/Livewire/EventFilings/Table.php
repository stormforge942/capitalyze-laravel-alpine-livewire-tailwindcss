<?php

namespace App\Http\Livewire\EventFilings;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use Illuminate\Support\Facades\Cache;


class Table extends BaseTable
{
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public array $config = [];
    public string $search = '';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateEventFilingsTable' => 'updateProps',
        ]);
    }

    public function updateProps(array $config, ?string $search)
    {
        $this->config = $config;
        $this->search = $search ?? '';

        $this->resetPage();
    }

    public function datasource()
    {
        $cacheKey = 'event_filings_datasource_' . md5(serialize($this->config) . $this->search);
        $cacheDuration = 60; 
    
        // TODO: Review PowerGrid's automatic caching behavior and its impact on Redis cache entries. Currently, PowerGrid caches the latest datasource response indefinitely, which can lead to duplicate cache entries (one for the latest search and one for the specific cache key). Consider monitoring the cache usage closely and evaluate the necessity of disabling PowerGrid's 'cached_data' feature (set 'cached_data' => false in config/livewire-powergrid.php) to prevent redundant caching.
        $result = Cache::remember($cacheKey, $cacheDuration, function () {
            $query = DB::connection('pgsql-xbrl')
                ->table('company_links')
                ->when(isset($this->config['in']), function ($query) {
                    $in = [];
                    foreach ($this->config['in'] as $item) {
                        $in[] = $item;
                        $in[] = $item . '/A';
                    }
                    $query->whereIn('form_type', $in);
                })
                ->when($this->search, fn ($q) => $q->where('registrant_name', 'ilike', "%{$this->search}%"));
            return $query->get();
        });
    
        return $result;
    }

    public function columns(): array
    {
        return [
            Column::make('Company Name', 'company', 'registrant_name')->sortable(),
            Column::make('Filing Type', 'form_type')->sortable(),
            Column::make('Description', 'description'),
            Column::make('Filing Date', 'filing_date')->sortable(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('registrant_name')
            ->addColumn('company', function ($row) {
                $url = route('company.profile', $row->symbol);
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$row->registrant_name}</a>";
            })
            ->addColumn('form_type')
            ->addColumn('description')
            ->addColumn('filing_date');
    }
}
