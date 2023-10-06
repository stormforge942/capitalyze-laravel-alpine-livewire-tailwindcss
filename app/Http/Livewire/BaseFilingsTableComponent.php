<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

abstract class BaseFilingsTableComponent extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false;
    public string $sortField = 'updated_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public bool $displayLoader = true;
    public $model;

    abstract public function data(): ?Builder;

    public function setUp(): array
    {
        return [
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    public function datasource()
    {
        return $this->data();
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('fiscal_year')
            ->addColumn('fiscal_period')
            ->addColumn('updated_at')
            ->addColumn('url', function ($item) {
                return ('<a class="text-blue" target="_blank"  href="' . $item->url . '">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Fiscal Year', 'fiscal_year')->sortable(),
            Column::make('Fiscal Period', 'fiscal_period')->sortable(),
            Column::make('Updated At', 'updated_at')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('fiscal_year', 'fiscal_year')->operators([]),
            Filter::inputText('fiscal_period', 'fiscal_period')->operators([]),
            Filter::inputText('updated_at', 'updated_at')->operators([]),
            Filter::inputText('url', 'url')->operators([]),
        ];
    }
}
