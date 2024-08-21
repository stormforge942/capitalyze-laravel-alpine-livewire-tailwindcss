<?php

namespace App\Http\Livewire\TrackInvestor;

use Illuminate\Support\Str;
use App\Powergrid\BaseTable;
use App\Models\RssFeed;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class RssFeedTable extends BaseTable
{
    public $quarter;
    public string $search = '';
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            [
                'filtersChanged' => 'setFilters',
            ]
        );
    }

    public function setFilters($filters)
    {
        $this->quarter = $filters['quarter'];
        $this->search = $filters['search'] ?? '';
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return RssFeed::query()
            ->when($this->quarter, function ($query) {
                return $query->where('report_calendar_or_quarter', '=', $this->quarter);
            })
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where('investor_name', 'ilike', $term);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Investor', 'formatted_name', 'investor_name')
                ->sortable()
                ->searchable(),

            Column::make('CIK', 'cik'),

            Column::make('Form Type', 'form_type')
                ->sortable(),

            Column::make('Acceptance Time', 'acceptance_time')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('investor_name')
            ->addColumn('formatted_name', function ($row) {
                return Str::title(strtolower($row->investor_name));
            })
            ->addColumn('cik')
            ->addColumn('form_type')
            ->addColumn('acceptance_time');
    }
}
