<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Powergrid\BaseTable;
use App\Services\TrackInvestorService;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class ListingTable extends BaseTable
{
    public string $type;
    public array $filters;
    public array $views = [];
    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    public $source = null;

    public function datasource(): Builder|Collection
    {
        // used in favorites
        if ($this->source) {
            return $this->source;
        }

        $method = $this->type === 'funds' ? 'fundsQuery' : 'mutualFundsQuery';

        return app(TrackInvestorService::class)
            ->{$method}(
                $this->filters,
                $this->views,
            );
    }

    public function columns(): array
    {
        if ($this->type === 'funds') {
            return [
                Column::make('Company', 'company', 'investor_name')->sortable(),
                Column::make('CIK', 'cik'),
                $this->numericColumn('Market Value', 'formatted_total_value', 'total_value'),
                $this->numericColumn('Holdings', 'formatted_portfolio_size', 'portfolio_size'),
                $this->numericColumn('Turnover', 'formatted_change_in_total_value', 'change_in_total_value'),
            ];
        }

        return [
            Column::make('Company', 'company', 'registrant_name')->sortable(),
            Column::make('CIK', 'cik', 'cik'),
            Column::make('Series ID', 'series_id'),
            Column::make('Class ID', 'class_id'),
            Column::make('Class Name', 'class_name'),
            $this->numericColumn('Market Value', 'formatted_total_value', 'total_value'),
            $this->numericColumn('Holdings', 'formatted_portfolio_size', 'portfolio_size'),
            $this->numericColumn('Turnover', 'formatted_change_in_total_value', 'change_in_total_value'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        if ($this->type === 'funds') {
            return PowerGrid::eloquent()
            ->addColumn('investor_name')
            ->addColumn('fund_symbol')
            ->addColumn('company', function ($row) {
                    $url = route('company.fund', ['fund' => $row->cik, 'tab' => 'holdings', 'from' => 'track-investors']);

                    return "<a href='{$url}' class='text-blue-600 hover:underline font-semibold'>{$row->investor_name}</a>";
                })
                ->addColumn('total_value')
                ->addColumn('formatted_total_value', fn($row) => niceNumber($row->total_value))
                ->addColumn('portfolio_size')
                ->addColumn('formatted_portfolio_size', fn($row) => number_format($row->portfolio_size))
                ->addColumn('cik')
                ->addColumn('change_in_total_value')
                ->addColumn('formatted_change_in_total_value', fn($row) => niceNumber($row->change_in_total_value));
        }

        return PowerGrid::eloquent()
            ->addColumn('registrant_name')
            ->addColumn('fund_symbol')
            ->addColumn('company', function ($row) {
                $url = route(
                    'company.mutual-fund',
                    [
                        'fund_symbol' => $row->fund_symbol,
                        'tab' => 'holdings',
                        'from' => 'track-investors',
                    ]
                );

                return "<a href='{$url}' class='text-blue-600 hover:underline font-semibold'>{$row->registrant_name} <small>({$row->fund_symbol})</small></a>";
            })
            ->addColumn('cik')
            ->addColumn('series_id')
            ->addColumn('class_id')
            ->addColumn('class_name')
            ->addColumn('total_value')
            ->addColumn('formatted_total_value', fn($row) => niceNumber($row->total_value))
            ->addColumn('portfolio_size')
            ->addColumn('formatted_portfolio_size', fn($row) => number_format($row->portfolio_size))
            ->addColumn('change_in_total_value')
            ->addColumn('formatted_change_in_total_value', fn($row) => niceNumber($row->change_in_total_value));
    }
}
