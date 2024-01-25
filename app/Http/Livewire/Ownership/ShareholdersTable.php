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
            Column::add()
                ->title('Fund')
                ->field('investor_name_formated', 'investor_name')
                ->sortable()
                ->searchable(),

            Column::make('Shares Held', 'ssh_prnamt')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Market Value', 'value')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% of Portfolio', 'weight')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Prior % of Portfolio', 'last_weight')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Change in Shares', 'change_in_shares')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% Ownership', 'ownership')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Date reported', 'signature_date')
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
            ->addColumn('investor_name')
            ->addColumn('investor_name_formated', function (CompanyFilings $companyFilings) {
                return ('<a class="text-blue" href="' . route('company.fund', [$companyFilings->cik, $this->ticker]) . '">' . Str::title($companyFilings->investor_name) . (!empty($companyFilings->put_call) ? ' <span class="text-sm font-bold">(' . $companyFilings->put_call . ')</span></a>' : '</a>'));
            })
            ->addColumn('ssh_prnamt', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->ssh_prnamt);
            })
            ->addColumn('value', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->value, 4);
            })
            ->addColumn('weight', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->weight, 4) . '%';
            })
            ->addColumn('last_weight', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->last_weight, 4) . '%';
            })
            ->addColumn('change_in_shares', function (CompanyFilings $companyFilings) {
                if ($companyFilings->change_in_shares >= 0) {
                    return number_format($companyFilings->change_in_shares);
                }

                return '<span class="text-red">(' . number_format(-1 * $companyFilings->change_in_shares) . ')</span>';
            })
            ->addColumn('ownership', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->ownership, 4) . '%';
            })
            ->addColumn('signature_date')
            ->addColumn('estimated_average_price', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->estimated_average_price, 4);
            });
    }
}
