<?php

namespace App\Http\Livewire\Euronext;

use App\Models\EuronextFilings;
use App\Http\Livewire\BaseFilingsTableComponent;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class FilingsTable extends BaseFilingsTableComponent
{
    public function data(): ?Builder
    {
        return EuronextFilings::query()
            ->where('symbol', '=', $this->model->symbol);
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('market')
            ->addColumn('market_full_name')
            ->addColumn('fiscal_year')
            ->addColumn('fiscal_period')
            ->addColumn('updated_at')
            ->addColumn('url', function (EuronextFilings $euronextFilings) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$euronextFilings->url.'">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Market', 'market')->sortable(),
            Column::make('Market Full Name', 'market_full_name')->sortable(),
            Column::make('Fiscal Year', 'fiscal_year')->sortable(),
            Column::make('Fiscal Period', 'fiscal_period')->sortable(),
            Column::make('Updated At', 'updated_at')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('market', 'market')->operators([]),
            Filter::inputText('market_full_name', 'market_full_name')->operators([]),
            Filter::inputText('fiscal_year', 'fiscal_year')->operators([]),
            Filter::inputText('fiscal_period', 'fiscal_period')->operators([]),
            Filter::inputText('updated_at', 'updated_at')->operators([]),
            Filter::inputText('url', 'url')->operators([]),
        ];
    }
}
