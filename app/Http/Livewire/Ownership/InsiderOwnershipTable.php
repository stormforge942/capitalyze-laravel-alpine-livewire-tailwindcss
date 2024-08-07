<?php

namespace App\Http\Livewire\Ownership;

use App\Models\InsiderOwnership;
use App\Powergrid\BaseTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class InsiderOwnershipTable extends BaseTable
{
    public string $ticker;
    public array $filters = [];
    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'filterInsiderOwnershipTable' => 'updateFilters',
        ]);
    }

    public function updateFilters(array $filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return InsiderOwnership::query()
            ->where('symbol', '=', $this->ticker)
            ->when(data_get($this->filters, 'search'), function ($query) {
                $term = '%' . $this->filters['search'] . '%';

                return $query->where('reporting_person', 'ilike', $term);
            })
            ->select([
                'symbol',
                'cik',
                'reporting_person',
                'securities_owned_following_transaction',
                'registrant_name',
                'url',
                'date',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Insider Name', 'reporting_person')->sortable(),
            Column::make('Quantity', 'formatted_quantity', 'securities_owned_following_transaction')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Transaction Date', 'reported_date', 'reported_date')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('reporting_person')
            ->addColumn('reported_date', function ($row) {
                if (!$row->date) {
                    return '-';
                }

                return Carbon::parse($row->date)->format('Y-m-d');
            })
            ->addColumn(
                'formatted_quantity',
                function ($row) {
                    if (is_null($row->securities_owned_following_transaction)) {
                        return '-';
                    }

                    return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `insider-transactions.form`, { url: `' . $row->url . '`, symbol: `' . $this->ticker . '`, quantity: ' . $row->securities_owned_following_transaction . ' })">' . number_format($row->securities_owned_following_transaction) . '</button>';
                }
            )
            ->addColumn('securities_owned_following_transaction')
            ->addColumn('url')
            ->addColumn('date');
    }
}
