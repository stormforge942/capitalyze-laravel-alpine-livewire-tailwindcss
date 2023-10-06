<?php

namespace App\Http\Livewire\Shanghai;

use App\Models\ShanghaiFilings;
use App\Http\Livewire\BaseFilingsTable;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class FilingsTable extends BaseFilingsTable
{
    public function data(): ?Builder
    {
        return ShanghaiFilings::query()
            ->where('symbol', '=', $this->model->symbol);
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('full_name')
            ->addColumn('short_name')
            ->addColumn('date')
            ->addColumn('url', function (ShanghaiFilings $shanghaiFilings) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$shanghaiFilings->url.'">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Full Name', 'full_name')->sortable(),
            Column::make('Short Name', 'short_name')->sortable(),
            Column::make('Date', 'date')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('full_name', 'full_name')->operators([]),
            Filter::inputText('short_name', 'short_name')->operators([]),
            Filter::inputText('date', 'date')->operators([]),
            Filter::inputText('url', 'url')->operators([]),
        ];
    }
}
