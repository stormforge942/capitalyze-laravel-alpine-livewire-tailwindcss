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
    public array $views;
    public array $filters;
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
        $this->filters = $filters;
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        $quarter = $this->filters['view'];
        $search = $this->filters['search'];

        return RssFeed::query()
            ->when($quarter, function ($query) use ($quarter) {
                if ($quarter === 'all') {
                    return $query;
                } else if ($quarter === 'most-recent') {
                    $date = array_keys($this->views)[2];
                    return $query->where('report_calendar_or_quarter', '=', $date);
                } else {
                    return $query->where('report_calendar_or_quarter', '=', $quarter);
                }
            })
            ->when($search, function ($query) use ($search) {
                $term = '%' . $search . '%';

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
                $name = Str::title(strtolower($row->investor_name));
                $url = route('company.fund', $row->cik);
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$name}</a>";
            })
            ->addColumn('cik')
            ->addColumn('form_type')
            ->addColumn('acceptance_time');
    }
}
