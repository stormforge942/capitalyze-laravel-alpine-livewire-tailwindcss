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

                return $query->where(
                    fn ($q) => $q->where('registrant_name', 'ilike', $term)
                        ->orWhere('fund_symbol', $this->search)
                );
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Fund', 'registrant_name_formated', 'registrant_name')
                ->sortable()
                ->searchable(),

            Column::make('Balance', 'balance_formatted', 'balance')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Market Value', 'market_value', 'val_usd')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% of Portfolio', 'portfolio_percent', 'weight')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Prior % of Portfolio', 'last_portfolio_percent', 'previous_weight')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Change in Balance', 'change_in_balance_formatted', 'change_in_balance')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% Ownership', 'ownership')
                // ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Date reported', 'period_of_report', 'period_of_report')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Estimated Avg Price Paid', 'estimated_average_price_formatted', 'estimated_average_price')
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
                $url = route('company.mutual-fund', [$fund->cik, $fund->fund_symbol, $fund->series_id, $fund->class_id, $fund->class_name]);

                $symbol = $fund->fund_symbol ? "<span class=\"text-sm font-semibold\">({$fund->fund_symbol})</span>" : '';

                return <<<HTML
                <a class="text-blue hover:underline" href="{$url}">{$fund->registrant_name} {$symbol}</a><br>
                <p class="text-sm text-gray-light2">Series ID: {$fund->series_id} <br> Class: {$fund->class_name} ({$fund->class_id})</p>
                HTML;
            })

            ->addColumn('balance')
            ->addColumn(
                'balance_formatted',
                fn ($fund) => redIfNegative($fund->balance, number_format(...))
            )

            ->addColumn('val_usd')
            ->addColumn(
                'market_value',
                fn ($fund) => redIfNegative($fund->val_usd, number_format(...))
            )

            ->addColumn('weight')
            ->addColumn(
                'portfolio_percent',
                fn ($fund) => redIfNegative($fund->weight, fn ($val) => round($val, 4) . '%')
            )

            ->addColumn('previous_weight')
            ->addColumn(
                'last_portfolio_percent',
                fn ($fund) => redIfNegative($fund->previous_weight, fn ($val) => round($val, 4) . '%')
            )

            ->addColumn('change_in_balance')
            ->addColumn(
                'change_in_balance_formatted',
                fn ($fund) => redIfNegative($fund->change_in_balance, number_format(...))
            )

            ->addColumn(
                'ownership',
                fn ($fund) => '-'
            )

            ->addColumn('period_of_report')

            ->addColumn('estimated_average_price')
            ->addColumn(
                'estimated_average_price_formatted',
                fn ($fund) => round($fund->estimated_average_price, 4)
            );
    }
}
