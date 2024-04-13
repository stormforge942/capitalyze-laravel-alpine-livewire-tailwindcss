<?php

namespace App\Http\Livewire\Ownership;

use Illuminate\Support\Str;
use App\Powergrid\BaseTable;
use App\Models\CompanyFilings;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class ShareholdersTable extends BaseTable
{
    public string $ticker = '';
    public $quarter = null;
    public string $search = '';
    public string $sortField = 'ownership';
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
        $this->quarter = $filters['quarter'];
        $this->search = $filters['search'];
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return CompanyFilings::query()
            ->where('symbol', '=', $this->ticker)
            ->when($this->quarter, function ($query) {
                return $query->where('report_calendar_or_quarter', '=', $this->quarter);
            })
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where('investor_name', 'ilike', $term);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Fund', 'investor_name_formated', 'investor_name')
                ->sortable()
                ->searchable(),

            Column::make('Shares Held', 'shares_held', 'ssh_prnamt')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Market Value', 'market_value', 'value')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% of Portfolio', 'portfolio_percent', 'weight')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Prior % of Portfolio', 'prior_portfolio_percent', 'last_weight')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Change in Shares', 'formatted_change_in_shares', 'change_in_shares')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% Ownership', 'ownership_percent', 'ownership')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Date reported', 'signature_date')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Estimated Avg Price Paid', 'formatted_estimated_average_price', 'estimated_average_price')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('investor_name')
            ->addColumn('investor_name_formated', function (CompanyFilings $companyFilings) {
                return ('<a class="text-blue hover:underline" href="' . route('company.fund', [$companyFilings->cik, $this->ticker]) . '">' . Str::title($companyFilings->investor_name) . (!empty($companyFilings->put_call) ? ' <span class="text-sm font-bold">(' . $companyFilings->put_call . ')</span></a>' : '</a>'));
            })
            ->addColumn('ssh_prnamt')
            ->addColumn('shares_held', function (CompanyFilings $companyFilings) {
                return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `filings-summary-s3-link-content`, {cik: `' . $companyFilings->cik . '`, date:  `' . $companyFilings->report_calendar_or_quarter . '`, name_of_issuer:  `' . $companyFilings->name_of_issuer . '`})">' . number_format($companyFilings->ssh_prnamt) . '</button>';
            })
            ->addColumn('value')
            ->addColumn('market_value', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->value);
            })
            ->addColumn('weight')
            ->addColumn('portfolio_percent', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->weight, 4) . '%';
            })
            ->addColumn('last_weight')
            ->addColumn('prior_portfolio_percent', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->last_weight, 4) . '%';
            })
            ->addColumn('change_in_shares')
            ->addColumn('formatted_change_in_shares', function (CompanyFilings $companyFilings) {
                if ($companyFilings->change_in_shares >= 0) {
                    return number_format($companyFilings->change_in_shares);
                }

                return '<span class="text-red">(' . number_format(-1 * $companyFilings->change_in_shares) . ')</span>';
            })
            ->addColumn('ownership')
            ->addColumn('ownership_percent', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->ownership, 4) . '%';
            })
            ->addColumn('signature_date')
            ->addColumn('estimated_average_price')
            ->addColumn('formatted_estimated_average_price', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->estimated_average_price, 4);
            });
    }
}
