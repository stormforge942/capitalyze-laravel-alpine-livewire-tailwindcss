<?php

namespace App\Http\Livewire;

use App\Models\CompanyInsider;
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

final class FundInsiderTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false; // default false
    public string $sortField = 'acceptance_time';
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
        $query = CompanyInsider::query()
            ->where('reporting_cik', '=', $this->cik);
    
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
            ->addColumn('cik')
            ->addColumn('registrant_name')
            ->addColumn('form_type')
            ->addColumn('reporting_person')
            ->addColumn('reporting_cik')
            ->addColumn('relationship_of_reporting_person')
            ->addColumn('individual_or_joint_filing')
            ->addColumn('derivative_or_nonderivative')
            ->addColumn('title_of_security')
            ->addColumn('transaction_date')
            ->addColumn('transaction_code')
            ->addColumn('amount_of_securities')
            ->addColumn('price_per_security')
            ->addColumn('acquired_or_disposed')
            ->addColumn('title_of_underlying_security')
            ->addColumn('amount_of_underlying_securities')
            ->addColumn('securities_owned_following_transaction')
            ->addColumn('ownership_form')
            ->addColumn('nature_of_ownership')
            ->addColumn('acceptance_time')
            ->addColumn('url', function (CompanyInsider $companyInsider) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$companyInsider->url.'">'.($companyInsider->url).'</a>');
            });
    }
    
    public function columns(): array
    {
        return [
            Column::make('Symbol', 'symbol')->sortable(),
            Column::make('CIK', 'cik')->sortable(),
            Column::make('Registrant Name', 'registrant_name')->sortable(),
            Column::make('Form Type', 'form_type')->sortable(),
            Column::make('Reporting Person', 'reporting_person')->sortable(),
            Column::make('Reporting CIK', 'reporting_cik')->sortable(),
            Column::make('Relationship of Reporting Person', 'relationship_of_reporting_person')->sortable(),
            Column::make('Individual or Joint Filing', 'individual_or_joint_filing')->sortable(),
            Column::make('Derivative or Nonderivative', 'derivative_or_nonderivative')->sortable(),
            Column::make('Title of Security', 'title_of_security')->sortable(),
            Column::make('Transaction Date', 'transaction_date')->sortable(),
            Column::make('Transaction Code', 'transaction_code')->sortable(),
            Column::make('Amount of Securities', 'amount_of_securities')->sortable(),
            Column::make('Price Per Security', 'price_per_security')->sortable(),
            Column::make('Acquired or Disposed', 'acquired_or_disposed')->sortable(),
            Column::make('Title of Underlying Security', 'title_of_underlying_security')->sortable(),
            Column::make('Amount of Underlying Securities', 'amount_of_underlying_securities')->sortable(),
            Column::make('Securities Owned Following Transaction', 'securities_owned_following_transaction')->sortable(),
            Column::make('Ownership Form', 'ownership_form')->sortable(),
            Column::make('Nature of Ownership', 'nature_of_ownership')->sortable(),
            Column::make('Acceptance Time', 'acceptance_time')->sortable(),
            Column::add()->title('URL')->field('url')->sortable(),
        ];
    }
    
    public function filters(): array
    {
        return [
            Filter::inputText('symbol', 'symbol')->operators([]),
            Filter::inputText('cik', 'cik')->operators([]),
            Filter::inputText('registrant_name', 'registrant_name')->operators([]),
            Filter::inputText('form_type', 'form_type')->operators([]),
            Filter::inputText('reporting_person', 'reporting_person')->operators([]),
            Filter::inputText('reporting_cik', 'reporting_cik')->operators([]),
            Filter::inputText('relationship_of_reporting_person', 'relationship_of_reporting_person')->operators([]),
            Filter::inputText('individual_or_joint_filing', 'individual_or_joint_filing')->operators([]),
            Filter::inputText('derivative_or_nonderivative', 'derivative_or_nonderivative')->operators([]),
            Filter::inputText('title_of_security', 'title_of_security')->operators([]),
            Filter::inputText('transaction_date', 'transaction_date')->operators([]),
            Filter::inputText('transaction_code', 'transaction_code')->operators([]),
            Filter::inputText('amount_of_securities', 'amount_of_securities')->operators([]),
            Filter::inputText('price_per_security', 'price_per_security')->operators([]),
            Filter::inputText('acquired_or_disposed', 'acquired_or_disposed')->operators([]),
            Filter::inputText('title_of_underlying_security', 'title_of_underlying_security')->operators([]),
            Filter::inputText('amount_of_underlying_securities', 'amount_of_underlying_securities')->operators([]),
            Filter::inputText('securities_owned_following_transaction', 'securities_owned_following_transaction')->operators([]),
            Filter::inputText('ownership_form', 'ownership_form')->operators([]),
            Filter::inputText('nature_of_ownership', 'nature_of_ownership')->operators([]),
            Filter::inputText('acceptance_time', 'acceptance_time')->operators([]),
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
