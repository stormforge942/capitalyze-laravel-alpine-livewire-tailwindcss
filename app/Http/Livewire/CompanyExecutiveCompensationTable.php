<?php

namespace App\Http\Livewire;

use App\Models\ExecutiveCompensation;
use Livewire\Livewire;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class CompanyExecutiveCompensationTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false; // default false
    public string $sortField = 'filing_date';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public bool $displayLoader = true;
    public array $dateRange = [];
    public array $dateFilter = [];
    public $symbol;
    public $current_filing_date;


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
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            ['dateRangeChanged' => 'setDateRange', 'dateRangeCleared' => 'clearDate', 'updateSelectedFilingDate' => 'update']
        );
    }

    public function update($value)
    {
        $this->current_filing_date = $value;
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
        $query = ExecutiveCompensation::query()
            ->where('symbol', '=', $this->symbol);

        if (!empty($this->current_filing_date)) {
            $query = $query->where('filing_date', $this->current_filing_date);
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
            ->addColumn('industry_title')
            ->addColumn('name_and_position')
            ->addColumn('filing_date', function (ExecutiveCompensation $executiveCompensation) {
                return ('<span data="filing_date">'. $executiveCompensation->filing_date .'</a>');
            })
            ->addColumn('salary')
            ->addColumn('bonus')
            ->addColumn('stock_award')
            ->addColumn('incentive_plan_compensation')
            ->addColumn('all_other_compensation')
            ->addColumn('url', function (ExecutiveCompensation $executiveCompensation) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$executiveCompensation->url.'">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Industry Title', 'industry_title')->sortable(),
            Column::make('Name And Position', 'name_and_position')->sortable(),
            Column::make('Filing Date', 'filing_date')->sortable(),
            Column::make('Salary', 'salary')->sortable(),
            Column::make('Bonus', 'bonus')->sortable(),
            Column::make('Stock Award', 'stock_award')->sortable(),
            Column::make('Incentive Plan Compensation', 'incentive_plan_compensation')->sortable(),
            Column::make('All Other Compensation', 'all_other_compensation')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('industry_title', 'industry_title')->operators([]),
            Filter::inputText('name_and_position', 'name_and_position')->operators([]),
            Filter::inputText('filing_date', 'filing_date')->operators([]),
            Filter::inputText('salary', 'salary')->operators([]),
            Filter::inputText('bonus', 'bonus')->operators([]),
            Filter::inputText('stock_award', 'stock_award')->operators([]),
            Filter::inputText('incentive_plan_compensation', 'incentive_plan_compensation')->operators([]),
            Filter::inputText('all_other_compensation', 'all_other_compensation')->operators([]),
            Filter::inputText('url', 'url')->operators([]),
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
