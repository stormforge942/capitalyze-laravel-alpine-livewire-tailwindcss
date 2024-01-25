<?php

namespace App\Http\Livewire\Ownership;

use App\Powergrid\BaseTable;
use App\Models\MutualFundsPage;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class MutualFundsTable extends BaseTable
{
    public string $ticker = '';
    public $periodRange = null;
    public string $search = '';
    public string $sortField = 'period_of_report';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            [
                'filtersChanged' => 'setFilters',
            ]
        );
    }

    public function setFilters($filters)
    {
        $this->periodRange = $filters['periodRange'];
        $this->search = $filters['search'];
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return MutualFundsPage::query()
            ->where('symbol', '=', $this->ticker)
            ->when($this->periodRange, function ($query) {
                return $query->whereBetween('period_of_report', $this->periodRange);
            })
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where('registrant_name', 'ilike', $term)
                    ->orWhere('fund_symbol', $this->search);
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Fund')
                ->field('registrant_name_formated', 'registrant_name')
                ->sortable()
                ->searchable(),

            Column::make('Shares Held', 'shares_held')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Market Value', 'market_value')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% of Portfolio', 'portfolio_percent')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Prior % of Portfolio', 'last_portfolio_percent')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Change in Shares', 'change_in_shares')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% Ownership', 'ownership')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Date reported', 'period_of_report')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::add()
                ->title('Estimated Avg Price Paid')
                ->field('estimated_average_price')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('cik')
            ->addColumn('fund_symbol')
            ->addColumn('series_id')
            ->addColumn('class_id')
            ->addColumn('registrant_name')
            ->addColumn('registrant_name_formated', function (MutualFundsPage $fund) {
                $url = route('company.mutual-fund', [$fund->cik, $fund->fund_symbol, $fund->series_id, $fund->class_id]);
                return ("<a class=\"text-blue\" href=\"{$url}\">{$fund->registrant_name}</a>");
            })
            ->addColumn('balance')
            ->addColumn('shares_held', function (MutualFundsPage $fund) {
                return custom_number_format($fund->balance);
            })
            ->addColumn('val_usd')
            ->addColumn('market_value', function (MutualFundsPage $fund) {
                return number_format($fund->val_usd, 4);
            })
            ->addColumn('weight')
            ->addColumn('portfolio_percent', function (MutualFundsPage $fund) {
                return number_format($fund->weight, 4) . '%';
            })
            ->addColumn('last_weight')
            ->addColumn('last_portfolio_percent', function (MutualFundsPage $fund) {
                return number_format($fund->last_weight, 4) . '%';
            })
            ->addColumn('change_in_balance')
            ->addColumn('change_in_shares', function (MutualFundsPage $fund) {
                if ($fund->change_in_balance >= 0) {
                    return number_format($fund->change_in_balance);
                }

                return '<span class="text-red">(' . number_format(-1 * $fund->change_in_balance) . ')</span>';
            })
            ->addColumn('ownership', function (MutualFundsPage $fund) {
                return '-';
            })
            ->addColumn('period_of_report')
            ->addColumn('estimated_average_price')
            ->addColumn('estimated_average_price', function (MutualFundsPage $fund) {
                return number_format($fund->estimated_average_price, 4);
            });
    }
}
