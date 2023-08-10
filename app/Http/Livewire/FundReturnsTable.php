<?php

namespace App\Http\Livewire;

use App\Models\FundReturns;
use Livewire\Livewire;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class FundReturnsTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false; // default false
    public string $sortField = 'period_report_restated';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public $fund;
    public $cik;
    public bool $displayLoader = true;

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
    * @return Builder<\App\Models\CompanyInsider>
    */
    public function datasource(): ?Builder
    {
        $query = FundReturns::query()
            ->where('cik', '=', str_pad($this->cik, 10, "0", STR_PAD_LEFT));
    
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
            ->addColumn('registrant_name')
            ->addColumn('symbol')
            ->addColumn('series_id')
            ->addColumn('year_to_date_return')
            ->addColumn('year_to_date_return_date')
            ->addColumn('highest_quarterly_return')
            ->addColumn('highest_quarterly_return_date')
            ->addColumn('lowest_quarterly_return')
            ->addColumn('lowest_quarterly_return_date');
    }

    public function columns(): array
    {
        return [
            Column::make('registrant_name', 'registrant_name')->sortable(),
            Column::make('symbol', 'symbol')->sortable(),
            Column::make('series_id', 'series_id')->sortable(),
            Column::make('year_to_date_return', 'year_to_date_return')->sortable(),
            Column::make('year_to_date_return_date', 'year_to_date_return_date')->sortable(),
            Column::make('highest_quarterly_return', 'highest_quarterly_return')->sortable(),
            Column::make('highest_quarterly_return_date', 'highest_quarterly_return_date')->sortable(),
            Column::make('lowest_quarterly_return', 'lowest_quarterly_return')->sortable(),
            Column::make('lowest_quarterly_return_date', 'lowest_quarterly_return_date')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('registrant_name', 'registrant_name')->operators([]),
            Filter::inputText('symbol', 'symbol')->operators([]),
            Filter::inputText('series_id', 'series_id')->operators([]),
            Filter::inputText('year_to_date_return', 'year_to_date_return')->operators([]),
            Filter::inputText('year_to_date_return_date', 'year_to_date_return_date')->operators([]),
            Filter::inputText('highest_quarterly_return', 'highest_quarterly_return')->operators([]),
            Filter::inputText('highest_quarterly_return_date', 'highest_quarterly_return_date')->operators([]),     
            Filter::inputText('lowest_quarterly_return', 'lowest_quarterly_return')->operators([]),     
            Filter::inputText('lowest_quarterly_return_date', 'lowest_quarterly_return_date')->operators([]),     
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
