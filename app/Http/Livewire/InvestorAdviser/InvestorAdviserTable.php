<?php

namespace App\Http\Livewire\InvestorAdviser;

use App\Powergrid\BaseTable;
use App\Services\InvestorAdviserService;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class InvestorAdviserTable extends BaseTable
{
    public array $filters;
    public array $views = [];
    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'filterInvestorAdviserTable' => 'updateFilters',
        ]);
    }

    public function updateFilters(array $filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function datasource(): Builder|Collection
    {
        return app(InvestorAdviserService::class)
            ->buildQuery(
                $this->filters,
                $this->views,
            );
    }

    public function columns(): array
    {
        return [
            Column::make('Legal Name', 'formatted_name', 'legal_name')->sortable(),
            Column::make('CIK', 'cik'),
            Column::make('Employees', 'formatted_employees', 'number_of_employees'),
            Column::make('Assets', 'formatted_assets', 'assets_under_management'),
            Column::make('Accounts', 'formatted_accounts', 'number_of_accounts'),
            Column::make('Date', 'date'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('legal_name')
            ->addColumn('formatted_name', function ($row) {
                $url = route(
                    'company.adviser',
                    [
                        'adviser' => $row->legal_name,
                        'tab' => 'holdings',
                        'from' => 'track-investors',
                    ]
                );

                return "<a href='{$url}' class='text-blue-600 hover:underline font-semibold'>{$row->legal_name}</a>";
            })
            ->addColumn('cik')
            ->addColumn('number_of_employees')
            ->addColumn('assets_under_management')
            ->addColumn('number_of_accounts')
            ->addColumn('date')
            ->addColumn('formatted_employees', fn($row) => number_format($row->number_of_employees))
            ->addColumn('formatted_assets', fn($row) => number_format($row->assets_under_management))
            ->addColumn('formatted_accounts', fn($row) => number_format($row->number_of_accounts));
    }
}
