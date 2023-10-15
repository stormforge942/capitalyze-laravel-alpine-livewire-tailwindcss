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
    public string $quarter = '';
    public string $sortField = 'ownership';

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
            ->where('symbol', '=', $this->ticker)
            ->when($this->quarter, function ($query) {
                return $query->where('report_calendar_or_quarter', '=', $this->quarter);
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Fund')
                ->field('investor_name_formated', 'investor_name')
                ->searchable(),

            Column::make('Shares Held', 'ssh_prnamt')
                ->sortable(),

            Column::make('Market Value', 'value')
                ->sortable(),

            Column::make('% of Portfolio', 'weight')
                ->sortable(),

            Column::make('Prior % of Portfolio', 'last_weight')
                ->sortable(),

            Column::make('Change in Shares', 'change_in_shares')
                ->sortable(),

            Column::make('% Ownership', 'ownership')
                ->sortable(),

            Column::make('Date reported', 'signature_date')
                ->sortable(),

            Column::add()
                ->title('Estimated Avg Price Paid')
                ->field('price_paid')
                ->sortable(),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('investor_name')
            ->addColumn('investor_name_formated', function (CompanyFilings $companyFilings) {
                return ('<a class="text-blue" href="/fund/' . $companyFilings->cik . '/holdings?Quarter-to-view=' . $this->quarter . '">' . Str::title($companyFilings->investor_name) . (!empty($companyFilings->put_call) ? ' <span class="text-sm font-bold">(' . $companyFilings->put_call . ')</span></a>' : '</a>'));
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
                if ($companyFilings->change_in_shares > 0) {
                    return number_format($companyFilings->change_in_shares);
                }

                return '<span class="text-red">(' . number_format(-1 * $companyFilings->change_in_shares) . ')</span>';
            })
            ->addColumn('ownership', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->ownership, 4) . '%';
            })
            ->addColumn('signature_date')
            ->addColumn('price_paid', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->price_paid, 4);
            });
    }
}
