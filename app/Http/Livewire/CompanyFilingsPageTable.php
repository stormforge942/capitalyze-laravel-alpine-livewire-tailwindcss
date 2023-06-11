<?php

namespace App\Http\Livewire;

use App\Models\CompanyLinks;
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

final class CompanyFilingsPageTable extends PowerGridComponent
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
        $query = CompanyLinks::query();
    
        if (!empty($this->dateFilter)) {
            $query = $query->whereBetween('filing_date', $this->dateFilter);
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
            ->addColumn('symbol', function (CompanyLinks $companyLinks) {
                return ('<a class="text-blue-500" target="_blank" href="/company/'.$companyLinks->symbol.'">'.$companyLinks->symbol.'</a>');
            })
            ->addColumn('cik')
            ->addColumn('filing_date')
            ->addColumn('acceptance_time')
            ->addColumn('form_type')
            ->addColumn('link', function (CompanyLinks $companyLinks) {
                return ('<a class="text-blue-500" target="_blank" href="'.$companyLinks->link.'">'.$companyLinks->link.'</a>');
            })
            ->addColumn('final_link', function (CompanyLinks $companyLinks) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$companyLinks->final_link.'">'.$companyLinks->final_link.'</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Symbol', 'symbol')->sortable(),
            Column::make('CIK', 'cik')->sortable(),
            Column::make('Filing Date', 'filing_date')->sortable(),
            Column::make('Acceptance Time', 'acceptance_time')->sortable(),
            Column::make('Form Type', 'form_type')->sortable(),
            Column::add()->title('Link')->field('link')->sortable(),
            Column::add()->title('Final Link')->field('final_link')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('symbol', 'symbol')->operators([]),
            Filter::inputText('cik', 'cik')->operators([]),
            Filter::inputText('filing_date', 'filing_date')->operators([]),
            Filter::inputText('acceptance_time', 'acceptance_time')->operators([]),
            Filter::inputText('form_type', 'form_type')->operators([]),
            Filter::inputText('link', 'link')->operators([]),
            Filter::inputText('final_link', 'final_link')->operators([]),
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
