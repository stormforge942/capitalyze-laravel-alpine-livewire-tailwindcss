<?php

namespace App\Http\Livewire\Tsx;

use App\Http\Livewire\BaseFilingsTableComponent;
use App\Models\TsxFilings;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class FilingsTable extends BaseFilingsTableComponent
{
    public function data(): ?Builder
    {
        return TsxFilings::query()
            ->where('symbol', '=', $this->model->symbol);
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('industry')
            ->addColumn('fiscal_year')
            ->addColumn('fiscal_period')
            ->addColumn('updated_at')
            ->addColumn('url', function (TsxFilings $tsxFilings) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$tsxFilings->url.'">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Industry', 'industry')->sortable(),
            Column::make('Fiscal Year', 'fiscal_year')->sortable(),
            Column::make('Fiscal Period', 'fiscal_period')->sortable(),
            Column::make('Updated At', 'updated_at')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('industry', 'industry')->operators([]),
            Filter::inputText('fiscal_year', 'fiscal_year')->operators([]),
            Filter::inputText('fiscal_period', 'fiscal_period')->operators([]),
            Filter::inputText('updated_at', 'updated_at')->operators([]),
            Filter::inputText('url', 'url')->operators([]),
        ];
    }
}
