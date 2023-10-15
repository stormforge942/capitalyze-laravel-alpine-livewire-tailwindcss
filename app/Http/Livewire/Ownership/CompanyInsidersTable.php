<?php

namespace App\Http\Livewire\Ownership;

use App\Powergrid\BaseTable;
use App\Models\CompanyInsider;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CompanyInsidersTable extends BaseTable
{
    public string $ticker = '';
    public string $sortField = 'acceptance_time';

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
            Column::make('Reporting CIK', 'reporting_cik')->sortable(),
            Column::make('Relationship of Reporting Person', 'relationship_of_reporting_person')->sortable(),
            Column::make('Individual or Joint Filing', 'individual_or_joint_filing')->sortable(),
            Column::make('Derivative or Nonderivative', 'derivative_or_nonderivative')->sortable(),
            Column::make('Title of Security', 'title_of_security')->sortable(),
            Column::make('Transaction Date', 'transaction_date')->sortable(),
            Column::make('Transaction Code', 'transaction_code')->sortable(),
        ];
    }
}
