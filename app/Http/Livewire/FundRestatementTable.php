<?php

namespace App\Http\Livewire;

use App\Models\CompanyRestatement;
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

final class FundRestatementTable extends PowerGridComponent
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
        $query = CompanyRestatement::query()
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
            ->addColumn('id')
            ->addColumn('qname')
            ->addColumn('period')
            ->addColumn('period_report_restated')
            ->addColumn('value_restated')
            ->addColumn('value_correction')
            ->addColumn('period_report_non_restated')
            ->addColumn('value_non_restated')
            ->addColumn('transition_type', function (CompanyRestatement $companyRestatement) {
                return $companyRestatement->transition_type == 1 ? 'Restated' : 'Correction';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Metrics', 'qname')->sortable(),
            Column::make('Period', 'period')->sortable(),
            Column::make('Restated on', 'period_report_restated')->sortable(),
            Column::make('Restated value', 'value_restated')->sortable(),
            Column::make('Correction', 'value_correction')->sortable(),
            Column::make('Originally reported date', 'period_report_non_restated')->sortable(),
            Column::make('Originally reported value', 'value_non_restated')->sortable(),
            Column::make('Transition', 'transition_type')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('qname', 'qname')->operators([]),
            Filter::inputText('period', 'period')->operators([]),
            Filter::inputText('period_report_restated', 'period_report_restated')->operators([]),
            Filter::inputText('value_restated', 'value_restated')->operators([]),
            Filter::inputText('value_correction', 'value_correction')->operators([]),
            Filter::inputText('period_report_non_restated', 'period_report_non_restated')->operators([]),
            Filter::inputText('value_non_restated', 'value_non_restated')->operators([]),
            Filter::select('transition_type')
            ->dataSource([
                ['id' => 1, 'value' => 'restated'],
                ['id' => 0, 'value' => 'correction']
            ])
            ->optionValue('id')
            ->optionLabel('value'),        
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
