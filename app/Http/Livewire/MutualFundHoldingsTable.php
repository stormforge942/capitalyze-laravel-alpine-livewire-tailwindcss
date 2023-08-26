<?php

namespace App\Http\Livewire;

use App\Models\MutualFundsPage;
use Livewire\Livewire;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class MutualFundHoldingsTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false; // default false
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public $cik;
    public $fund_symbol;
    public $series_id;
    public $class_id;
    public string $selectedQuarter = '';
    public bool $displayLoader = true;

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            ['quarterChanged' => 'setQuarter']
        );
    }

    public function setQuarter($quarter)
    {
        $this->selectedQuarter = $quarter;
        $this->resetPage();
        $this->datasource();
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        return [
            Exportable::make('my-export-file')
                ->striped('#A6ACCD')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\CompanyFilings>
    */
    public function datasource(): ?Builder
    {
        $query = MutualFundsPage::query()
        ->where('cik', '=', $this->cik)
        ->where('fund_symbol', '=', $this->fund_symbol)
        ->where('series_id', '=', $this->series_id)
        ->where('class_id', '=', $this->class_id);
        

        if ($this->selectedQuarter !== '') {
            $query = $query->where('period_of_report', '=', $this->selectedQuarter);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('registrant_name') // Fund
            ->addColumn('symbol')
            ->addColumn('isin')
            ->addColumn('fund_symbol')
            ->addColumn('name')
            ->addColumn('cik')
            ->addColumn('series_id')
            ->addColumn('class_id')
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
    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('Registrant Name', 'registrant_name')->sortable(),
            Column::make('Symbol', 'symbol')->sortable(),
            Column::make('ISIN', 'isin')->sortable(),
            Column::make('Fund Symbol', 'fund_symbol')->sortable(),
            Column::make('Name', 'name')->sortable(),
            Column::make('CIK', 'cik')->sortable(),
            Column::make('Series ID', 'series_id')->sortable(),
            Column::make('Class ID', 'class_id')->sortable(),
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
            Filter::inputText('series_id', 'series_id')->operators([]),
            Filter::inputText('class_id', 'class_id')->operators([]),
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

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid CompanyFilings Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('company-filings.edit', ['company-filings' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('company-filings.destroy', ['company-filings' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid CompanyFilings Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($company-filings) => $company-filings->id === 1)
                ->hide(),
        ];
    }
    */
}
