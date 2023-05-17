<?php

namespace App\Http\Livewire;

use App\Models\CompanyFilings;
use Livewire\Livewire;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class CompanyShareholdersTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false; // default false
    public string $primaryKey = 'composite_key';
    public string $sortField = 'ownership';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public $company;
    public $ticker;
    public $period;
    public string $selectedQuarter = '';

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
        $this->showCheckBox();

        return [
            Exportable::make('my-export-file')
                ->striped('#A6ACCD')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
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
        $query = CompanyFilings::query()
            ->select('*', DB::raw("CONCAT(cik, '-', cusip, '-', put_call, '-', report_calendar_or_quarter) as composite_key"))
            ->where('symbol', '=', $this->ticker);

        if ($this->selectedQuarter !== '') {
            $query = $query->where('report_calendar_or_quarter', '=', $this->selectedQuarter);
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
            ->addColumn('investor_name') // Fund
            ->addColumn('investor_name_formated', function (CompanyFilings $companyFilings) {
                return ($companyFilings->investor_name . (!empty($companyFilings->put_call) ? ' <span class="text-sm font-bold">(' . $companyFilings->put_call . ')</span>' : ''));
            }) // Fund
            ->addColumn('ssh_prnamt') // Shares Held or Principal Amt
            ->addColumn('value', function(CompanyFilings $companyFilings) {
                return number_format($companyFilings->value, 0).' $';
            }) // Market Value
            ->addColumn('weight', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->weight, 4) . '%';
            }) // % of Portfolio
            ->addColumn('last_weight', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->last_weight, 4) . '%';
            }) // Prior % of Portfolio
            ->addColumn('change_in_shares') // Change in Shares
            ->addColumn('ownership', function (CompanyFilings $companyFilings) {
                return number_format($companyFilings->ownership, 4) . '%';
            })
            // ->addColumn('source') // Source
            ->addColumn('signature_date') // Date reported
            ->addColumn('report_calendar_or_quarter') // Source Date
            ->addColumn('first_added') // Qtr 1st Owned
            ->addColumn('price_paid'); // Estimated Avg Price Paid
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
            Column::add()
                ->title('Fund')
                ->field('investor_name_formated', 'investor_name')
                ->searchable()
                ->sortable(),

            Column::make('Shares Held or Principal Amt', 'ssh_prnamt')
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

            Column::make('Source Date', 'report_calendar_or_quarter')
                ->sortable(),
                
            Column::make('Qtr 1st Owned', 'first_added')
                ->sortable(),
    
            Column::make('Estimated Avg Price Paid', 'price_paid')
                ->sortable(),
        ];
    }


    // public function filters(): array
    // {
    //     return [
    //     Filter::inputText('investor_name', 'investor_name')
    //         ->operators(['contains', 'is', 'is_not']),
    //     ];
    // }

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
