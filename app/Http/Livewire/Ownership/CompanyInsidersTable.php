<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use App\Powergrid\BaseTable;
use App\Models\CompanyInsider;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use Illuminate\Contracts\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class CompanyInsidersTable extends BaseTable
{
    use AsTab;

    public string $ticker;
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';

    public static function title(): string
    {
        return 'Company Insiders';
    }

    public function mount(array $data = []): void
    {
        parent::mount();
        $this->ticker = $data['company']['ticker'];
    }

    public function datasource(): ?Builder
    {
        $query = CompanyInsider::query()
            ->where('symbol', '=', $this->ticker);

        return $query;
    }

    public function columns(): array
    {
        return [
            Column::make('Reporting Person', 'reporting_person')->sortable(),
            Column::make('Reporting CIK', 'reporting_cik')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Relationship of Reporting Person', 'relationship_of_reporting_person')->sortable(),
            Column::make('Individual or Joint Filing', 'individual_or_joint_filing')->sortable(),
            Column::make('Derivative or Nonderivative', 'derivative_or_nonderivative')->sortable(),
            Column::make('Title of Security', 'title_of_security')->sortable(),
            Column::make('Transaction Date', 'transaction_date')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Transaction Code', 'transaction_code')->sortable(),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('reporting_person')
            ->addColumn('reporting_cik')
            ->addColumn('relationship_of_reporting_person')
            ->addColumn('individual_or_joint_filing')
            ->addColumn('derivative_or_nonderivative')
            ->addColumn('title_of_security')
            ->addColumn('transaction_date')
            ->addColumn('transaction_code');
    }
}
