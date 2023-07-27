<?php

namespace App\Http\Livewire;

use App\Models\Delistings;
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

final class DelistingsTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false; // default false
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public bool $displayLoader = true;
    public array $dateRange = [];
    public array $dateFilter = [];


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
            ['dateRangeChanged' => 'setDateRange', 'dateRangeCleared' => 'clearDate']
        );
    }

    public function clearDate()
    {   
        $this->dateFilter = [];
        $this->resetPage();
        $this->datasource();
    }

    public function setDateRange($dateRange)
    {   
        $this->dateRange = $dateRange;
    
        // Extract dates from the $dateRange array
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];
    
        // Convert dates to a format that the database can understand
        $this->dateFilter = [
            Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s'), 
            Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s')
        ];        
    
        $this->resetPage();
        $this->datasource();
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
        $query = Delistings::query();

        if (!empty($this->dateFilter)) {
            $query = $query->whereBetween('acceptance_time', $this->dateFilter);
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
            ->addColumn('symbol')
            ->addColumn('acceptance_time')
            ->addColumn('cik')
            ->addColumn('registrant_name')
            ->addColumn('exchange')
            ->addColumn('description_of_security')
            ->addColumn('rule_provision')
            ->addColumn('description_of_rule_provision')
            ->addColumn('url', function (Delistings $delistings) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$delistings->url.'">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Symbol', 'symbol')->sortable(),
            Column::make('Acceptance Time', 'acceptance_time')->sortable(),
            Column::make('CIK', 'cik')->sortable(),
            Column::make('Registrant Name', 'registrant_name')->sortable(),
            Column::make('Exchange', 'exchange')->sortable(),
            Column::make('Description Of Security', 'description_of_security')->sortable(),
            Column::make('Rule Provision', 'rule_provision')->sortable(),
            Column::make('Description Of Rule Provision', 'description_of_rule_provision')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('symbol', 'symbol')->operators([]),
            Filter::inputText('acceptance_time', 'acceptance_time')->operators([]),
            Filter::inputText('cik', 'cik')->operators([]),
            Filter::inputText('registrant_name', 'registrant_name')->operators([]),
            Filter::inputText('exchange', 'exchange')->operators([]),
            Filter::inputText('description_of_security', 'description_of_security')->operators([]),
            Filter::inputText('rule_provision', 'rule_provision')->operators([]),
            Filter::inputText('description_of_rule_provision', 'description_of_rule_provision')->operators([]),
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
