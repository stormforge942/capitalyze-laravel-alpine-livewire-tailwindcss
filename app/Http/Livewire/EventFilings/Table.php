<?php

namespace App\Http\Livewire\EventFilings;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

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

    public function datasource()
    {
        // dd(1);
        return DB::connection('pgsql-xbrl')
            ->table('company_links')
            ->when(isset($this->config['in']), function ($query) {
                $query->whereIn('form_type', $this->config['in']);
            })
            // ->when(isset($this->config['patterns']), function ($query) {
            //     foreach ($this->config['patterns'] as $pattern) {
            //         $query->orWhere('form_type', 'ilike', $pattern);
            //     }
            // })
            ->when($this->search, fn ($q) => $q->where('registrant_name', 'ilike', "%{$this->search}%"));
    }

    public function updateProps(array $config, ?string $search)
    {
        $this->config = $config;
        $this->search = $search ?? '';
    }

    public function columns(): array
    {
        return [
            Column::make('Company Name', 'registrant_name')->sortable(),
            Column::make('Filing Type', 'form_type')->sortable(),
            Column::make('Description', 'description'),
            Column::make('Filing Date', 'filing_date')->sortable(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('registrant_name')
            ->addColumn('form_type')
            ->addColumn('description')
            ->addColumn('filing_date');
    }
}
