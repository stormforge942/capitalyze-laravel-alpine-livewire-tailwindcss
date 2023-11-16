<?php

namespace App\Http\Livewire\Ownership;

use App\Powergrid\BaseTable;
use App\Models\CompanyFilings;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class FundHoldingsTable extends BaseTable
{
    public $quarter = null;
    public string $cik = '';
    public string $sortField = 'ownership';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            ['quarterChanged' => 'setQuarter']
        );
    }

    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return CompanyFilings::query()
            ->where('cik', '=', $this->cik)
            ->when($this->quarter, function ($query) {
                return $query->where('report_calendar_or_quarter', '=', $this->quarter);
            });
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('name_of_issuer')
            ->addColumn('investor_name_formated', function (CompanyFilings $companyFilings) {
                return '<a href=" ' . route('company.ownership', $companyFilings->symbol) . ' " class="text-blue">' . $companyFilings->symbol . (!empty($companyFilings->name_of_issuer) ? ' <span class="text-xs font-light">(' . $companyFilings->name_of_issuer . ')<span>' : '') . '</button>';
            })
            ->addColumn('ssh_prnamt', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->ssh_prnamt);
            })
            ->addColumn('value', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->value, 0) . ' $';
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
            ->addColumn('report_calendar_or_quarter');
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Company')
                ->field('investor_name_formated', 'name_of_issuer')
                ->searchable()
                ->sortable(),

            Column::make('Shares Held or Principal Amt', 'ssh_prnamt')
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

            Column::make('Source Date', 'report_calendar_or_quarter')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }
}
