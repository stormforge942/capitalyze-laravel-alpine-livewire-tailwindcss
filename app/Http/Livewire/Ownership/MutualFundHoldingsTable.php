<?php

namespace App\Http\Livewire\Ownership;

use Illuminate\Support\Js;
use App\Powergrid\BaseTable;
use App\Models\MutualFundsPage;
use App\Services\OwnershipHistoryService;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class MutualFundHoldingsTable extends BaseTable
{
    public $fund;
    public $periodRange = null;
    public $quarter = null;
    public bool $redirectToOverview = false;
    public string $search = '';
    public string $sortField = 'weight';
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
        $this->quarter = $filters['quarter'];
        $this->search = $filters['search'];
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return MutualFundsPage::query()
            ->where([
                'fund_symbol' => $this->fund['fund_symbol'],
                'cik' => $this->fund['cik'],
                'series_id' => $this->fund['series_id'],
                'class_id' => $this->fund['class_id'],
                'class_name' => $this->fund['class_name'],
            ])
            ->when($this->periodRange, function ($query) {
                return $query->whereBetween('period_of_report', $this->periodRange);
            })
            ->when($this->quarter, function ($query) {
                return $query->whereBetween('period_of_report', explode('|', $this->quarter));
            })
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where(
                    fn ($q) => $q->where('name', 'ilike', $term)
                        ->orWhere('symbol', 'ilike', $term) // symbols are in uppercase
                );
            });
    }

    public function columns(): array
    {
        return [
            Column::make('', 'history'),

            Column::make('Company', 'name_formatted', 'name')
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
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('name')
            ->addColumn('name_formatted', function ($fund) {
                if (!$fund->symbol) {
                    return $fund->name;
                }

                if ($this->redirectToOverview) {
                    $href = route('company.profile', $fund->symbol);
                } else {
                    if ($fund->symbol === OwnershipHistoryService::getCompany()) {
                        $attrs = ['ticker' => $fund->symbol];
                    } else {
                        $attrs = ['ticker' => $fund->symbol, 'start' => OwnershipHistoryService::getCompany(), 'tab' => 'mutual-funds'];
                    }

                    $href = route(
                        'company.ownership',
                        $attrs
                    );
                }
                return '<a href=" ' . $href . ' " class="text-blue hover:underline">' . $fund->symbol . (!empty($fund->name) ? ' <span class="text-xs font-light">(' . $fund->name . ')<span>' : '') . '</a>';
            })

            ->addColumn('balance')
            ->addColumn(
                'balance_formatted',
                function ($fund) {
                    $data = "{fund: {cik: '{$fund->cik}', fund_symbol: '{$fund->fund_symbol}', series_id: '{$fund->series_id}', class_id: '{$fund->class_id}', class_name: '{$fund->class_name}'}, date: '{$fund->period_of_report}', balance: '{$fund->balance}'}";
                    return '<button class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `ownership.nport-summary-s3-link-content`, ' . $data . ')">' . redIfNegative($fund->balance, number_format(...))  . '</button>';
                }
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

            ->addColumn('history', function (MutualFundsPage $fund) {
                $company = Js::from([
                    'name' => $fund->name,
                    'symbol' => $fund->symbol,
                ])->toHtml();

                $fund = Js::from([
                    'fund_symbol' => $this->fund['fund_symbol'],
                    'cik' => $this->fund['cik'],
                    'series_id' => $this->fund['series_id'],
                    'class_id' => $this->fund['class_id'],
                ])->toHtml();

                return <<<HTML
                <button class="px-2 py-1 bg-green-light hover:bg-green-dark rounded" @click.prevent="Livewire.emit('modal.open', 'ownership.mutual-fund-history', { fund: $fund, company: $company })">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 7.99992H4.66667V13.9999H2V7.99992ZM11.3333 5.33325H14V13.9999H11.3333V5.33325ZM6.66667 1.33325H9.33333V13.9999H6.66667V1.33325Z" fill="#121A0F"/>
                    </svg>
                </button>
                HTML;
            });
    }
}
