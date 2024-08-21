<?php

namespace App\Http\Livewire\Ownership;

use App\Models\BeneficialOwned;
use App\Powergrid\BaseTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class BeneficialOwnershipTable extends BaseTable
{
    public string $ticker;
    public array $filters = [];
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'filterBeneficialOwnershipTable' => 'updateFilters',
        ]);
    }

    public function updateFilters(array $filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return BeneficialOwned::query()
            ->where('symbol', '=', $this->ticker)
            ->when(data_get($this->filters, 'search'), function ($query) {
                $term = '%' . $this->filters['search'] . '%';

                return $query->where('name_of_reporting_person', 'ilike', $term);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Name of Report', 'name_of_reporting_person')->sortable(),
            Column::make('CUSIP', 'cusip'),
            Column::make('Citizenship or Place of Inc', 'citizenship_or_place_of_organization')
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Amount', 'formatted_amount', 'amount_beneficially_owned')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Sole Voting Power', 'formatted_voting_power', 'sole_voting_power')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Sole Dispositive Power', 'formatted_sole_dispositive_power', 'sole_dispositive_power')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Shared Dispositive Power', 'formatted_shared_dispositive_power', 'shared_dispositive_power')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Percent of Class', 'percent_of_class')
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Report Type', 'type_of_reporting_person')
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Filing Date', 'filing_date')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('amount_beneficially_owned')
            ->addColumn('formatted_amount', function ($row) {
                if (is_null($row->amount_beneficially_owned)) {
                    return '-';
                }

                return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `s3-link-html-content`, { url: `' . $row->s3_url . '`, sourceLink: `' . $row->url . '`, quantity: ' . $row->amount_beneficially_owned . ' })">' . number_format($row->amount_beneficially_owned) . '</button>';
            })
            ->addColumn('shared_dispositive_power')
            ->addColumn('formatted_shared_dispositive_power', fn ($row) => number_format($row->shared_dispositive_power))
            ->addColumn('sole_dispositive_power')
            ->addColumn('formatted_sole_dispositive_power', fn ($row) => number_format($row->sole_dispositive_power))
            ->addColumn('sole_voting_power')
            ->addColumn('formatted_voting_power', fn ($row) => number_format($row->sole_voting_power));
    }
}
