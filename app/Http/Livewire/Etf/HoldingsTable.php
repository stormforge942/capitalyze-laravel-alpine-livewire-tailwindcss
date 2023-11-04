<?php

namespace App\Http\Livewire\Etf;

use App\Models\Etfs;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class HoldingsTable extends PowerGridComponent
{
    use ActionButton;

    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];

    public $etf;
    public string $quarter;

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            ['quarterChanged']
        );
    }

    public function quarterChanged($quarter)
    {
        $this->quarter = $quarter;
        $this->resetPage();
    }

    public function setUp(): array
    {
        return [
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Etfs::query()
            ->where('cik', $this->etf->cik)
            ->where('etf_symbol', $this->etf->etf_symbol)
            ->when($this->quarter, fn ($q) => $q->where('period_of_report', '=', $this->quarter));
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('registrant_name')
            ->addColumn('symbol')
            ->addColumn('isin')
            ->addColumn('fund_symbol')
            ->addColumn('name')
            ->addColumn('cik')
            ->addColumn('acceptance_time')
            ->addColumn('period_of_report')
            ->addColumn('lei')
            ->addColumn('title')
            ->addColumn('cusip')
            ->addColumn('balance')
            ->addColumn('units')
            ->addColumn('cur_cd')
            ->addColumn('val_usd')
            ->addColumn('pct_val')
            ->addColumn('payoff_profile')
            ->addColumn('asset_cat')
            ->addColumn('issuer_cat')
            ->addColumn('inv_country')
            ->addColumn('is_restricted_sec')
            ->addColumn('fair_val_level')
            ->addColumn('is_cash_collateral')
            ->addColumn('is_non_cash_collateral')
            ->addColumn('is_loan_by_fund');
    }

    public function columns(): array
    {
        return [
            Column::make('Registrant Name', 'registrant_name')->sortable(),
            Column::make('Symbol', 'symbol')->sortable(),
            Column::make('ISIN', 'isin')->sortable(),
            Column::make('Fund Symbol', 'fund_symbol')->sortable(),
            Column::make('Name', 'name')->sortable(),
            Column::make('CIK', 'cik')->sortable(),
            Column::make('Acceptance Time', 'acceptance_time')->sortable(),
            Column::make('Period Of Report', 'period_of_report')->sortable(),
            Column::make('LEI', 'lei')->sortable(),
            Column::make('Title', 'title')->sortable(),
            Column::make('CUSIP', 'cusip')->sortable(),
            Column::make('Balance', 'balance')->sortable(),
            Column::make('Units', 'units')->sortable(),
            Column::make('Cur_cd', 'cur_cd')->sortable(),
            Column::make('val_usd', 'val_usd')->sortable(),
            Column::make('pct_val', 'pct_val')->sortable(),
            Column::make('Payoff Profile', 'payoff_profile')->sortable(),
            Column::make('Asset Cat', 'asset_cat')->sortable(),
            Column::make('Issuer Cat', 'issuer_cat')->sortable(),
            Column::make('Inv Country', 'inv_country')->sortable(),
            Column::make('Is Restricted Sec', 'is_restricted_sec')->sortable(),
            Column::make('Fair Val Level', 'fair_val_level')->sortable(),
            Column::make('Is Cash Collateral', 'is_cash_collateral')->sortable(),
            Column::make('Is Non Cash Collateral', 'is_non_cash_collateral')->sortable(),
            Column::make('Is Loan By Fund', 'is_loan_by_fund')->sortable()
        ];
    }


    public function filters(): array
    {
        return [
            Filter::inputText('registrant_name', 'registrant_name')->operators([]),
            Filter::inputText('symbol', 'symbol')->operators([]),
            Filter::inputText('isin', 'isin')->operators([]),
            Filter::inputText('fund_symbol', 'fund_symbol')->operators([]),
            Filter::inputText('name', 'name')->operators([]),
            Filter::inputText('cik', 'cik')->operators([]),
            Filter::inputText('acceptance_time', 'acceptance_time')->operators([]),
            Filter::inputText('period_of_report', 'period_of_report')->operators([]),
            Filter::inputText('lei', 'lei')->operators([]),
            Filter::inputText('title', 'title')->operators([]),
            Filter::inputText('cusip', 'cusip')->operators([]),
            Filter::inputText('balance', 'balance')->operators([]),
            Filter::inputText('units', 'units')->operators([]),
            Filter::inputText('cur_cd', 'cur_cd')->operators([]),
            Filter::inputText('val_usd', 'val_usd')->operators([]),
            Filter::inputText('pct_val', 'pct_val')->operators([]),
            Filter::inputText('payoff_profile', 'payoff_profile')->operators([]),
            Filter::inputText('asset_cat', 'asset_cat')->operators([]),
            Filter::inputText('issuer_cat', 'issuer_cat')->operators([]),
            Filter::inputText('inv_country', 'inv_country')->operators([]),
            Filter::inputText('is_restricted_sec', 'is_restricted_sec')->operators([]),
            Filter::inputText('fair_val_level', 'fair_val_level')->operators([]),
            Filter::inputText('is_cash_collateral', 'is_cash_collateral')->operators([]),
            Filter::inputText('is_non_cash_collateral', 'is_non_cash_collateral')->operators([]),
            Filter::inputText('is_loan_by_fund', 'is_loan_by_fund')->operators([])
        ];
    }
}
