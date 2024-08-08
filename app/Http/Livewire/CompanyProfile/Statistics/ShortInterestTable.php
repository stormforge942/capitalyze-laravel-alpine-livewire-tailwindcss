<?php

namespace App\Http\Livewire\CompanyProfile\Statistics;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class ShortInterestTable extends BaseTable
{
    public string $sortField = 'settlement_date';
    public string $sortDirection = 'desc';
    public array $config = [];
    public string $search = '';
    public $symbol;

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateShortInterestTable' => 'updateProps',
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
        return DB::connection('pgsql-xbrl')
            ->table('short_interest')
            ->when($this->symbol, fn ($q) => $q->where('symbol', $this->symbol))
            ->when($this->search, fn ($q) => $q->where('registrant_name', 'ilike', "%{$this->search}%"));
    }

    public function columns(): array
    {
        return [
            Column::make('Current Positions(% Change)', 'current_positions'),
            Column::make('Average Daily Volume', 'average_daily_volume')->sortable(),
            Column::make('Date', 'settlement_date')->sortable(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('settlement_date')
            ->addColumn('current_positions', function ($row) {
                return $row->current_short_positions . '(' . $row->percentage_change_in_positions . '%)';
            })
            ->addColumn('average_daily_volume');
    }
}
