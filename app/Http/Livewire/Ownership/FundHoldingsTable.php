<?php

namespace App\Http\Livewire\Ownership;

use App\Powergrid\BaseTable;
use App\Models\CompanyFilings;
use Illuminate\Support\Facades\Storage;
use App\Services\OwnershipHistoryService;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class FundHoldingsTable extends BaseTable
{
    public $quarter = null;
    public bool $redirectToOverview = false;
    public string $cik = '';
    public string $sortField = 'weight';
    public string $sortDirection = 'desc';
    public string $search = '';

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            ['filtersChanged' => 'setFilters']
        );
    }

    private function getLogoUrl($ticker)
    {
        if (Storage::disk('s3')->exists("company_logos/{$ticker}.png")) {
            return Storage::disk('s3')->url("company_logos/{$ticker}.png");
        } else {
            return asset('svg/logo.svg');
        }
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
            ->where('cik', '=', $this->cik)
            ->when($this->quarter, function ($query) {
                return $query->where('report_calendar_or_quarter', '=', $this->quarter);
            })
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where(
                    fn ($q) => $q->where('symbol', 'ilike', $term)
                        ->orWhere('name_of_issuer', 'ilike', $term)
                ); // remove this if the query is too slow
            })
            ->where('value', '>', 0);
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('symbol')
            ->addColumn('name_of_issuer')
            ->addColumn('name', function (CompanyFilings $companyFilings) {
                if ($this->redirectToOverview) {
                    $href = route('company.profile', $companyFilings->symbol);
                } else {
                    if ($companyFilings->symbol === OwnershipHistoryService::getCompany()) {
                        $attrs = ['ticker' => $companyFilings->symbol];
                    } else {
                        $attrs = ['ticker' => $companyFilings->symbol, 'start' => OwnershipHistoryService::getCompany()];
                    }

                    $href = route(
                        'company.ownership',
                        $attrs
                    );
                }

                $url = $this->getLogoUrl($companyFilings->symbol);

                return '<a href=" ' . $href . ' " class="text-blue hover:underline flex flex-row items-center gap-x-2">' . "<img src='{$url}' width='32' height='32' style='width: 32px;' />" . "<span>" . $companyFilings->symbol . (!empty($companyFilings->name_of_issuer) ? ' <span class="text-xs font-light">(' . $companyFilings->name_of_issuer . ')<span>' : '') . '</span></a>';
            })
            ->addColumn('ssh_prnamt')
            ->addColumn('ssh_prnamt_formatted', function (CompanyFilings $companyFilings) {
                return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `filings-summary-s3-link-content`, {cik: `' . $companyFilings->cik . '`, date:  `' . $companyFilings->report_calendar_or_quarter .'`, name_of_issuer:  `' . $companyFilings->name_of_issuer . '`})">' . number_format($companyFilings->ssh_prnamt) . '</button>';
            })
            ->addColumn('value')
            ->addColumn('market_value', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->value, 0) . ' $';
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
            ->addColumn('report_calendar_or_quarter')
            ->addColumn('history', function (CompanyFilings $companyFilings) {
                if ($companyFilings->name_of_issuer) {
                    $companyName = $companyFilings->name_of_issuer . " (" . $companyFilings->symbol . ")";
                } else {
                    $companyName = $companyFilings->symbol;
                }

                return <<<HTML
                <button class="px-2 py-1 bg-green-light hover:bg-green-dark transition-all rounded" @click.prevent="Livewire.emit('modal.open', 'ownership.fund-history', { fund: '$this->cik', company: { name: '$companyName', symbol: '$companyFilings->symbol' } })">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 7.99992H4.66667V13.9999H2V7.99992ZM11.3333 5.33325H14V13.9999H11.3333V5.33325ZM6.66667 1.33325H9.33333V13.9999H6.66667V1.33325Z" fill="#121A0F"/>
                    </svg>
                </button>
                HTML;
            });
    }

    public function columns(): array
    {
        return [
            Column::make('', 'history'),

            Column::make('Company', 'name', 'symbol')
                ->searchable()
                ->sortable(),

            Column::make('Shares Held', 'ssh_prnamt_formatted', 'ssh_prnamt')
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

            Column::make('Source Date', 'report_calendar_or_quarter')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }
}
