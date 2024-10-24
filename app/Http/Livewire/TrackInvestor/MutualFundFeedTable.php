<?php

namespace App\Http\Livewire\TrackInvestor;

use Illuminate\Support\Str;
use App\Powergrid\BaseTable;
use App\Models\MutualFundFeed;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class MutualFundFeedTable extends BaseTable
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

        return MutualFundFeed::query()
            ->when($quarter, function ($query) use ($quarter) {
                if ($quarter === 'all') {
                    return $query;
                } else if ($quarter === 'most-recent') {
                    $date = Carbon::parse(array_keys($this->views)[2]);
                    $period = [$date->startOfQuarter()->format('Y-m-d'), $date->endOfQuarter()->format('Y-m-d')];
                    return $query->whereBetween('period_of_report', $period);
                } else {
                    $date = Carbon::parse($quarter);
                    $period = [$date->startOfQuarter()->format('Y-m-d'), $date->endOfQuarter()->format('Y-m-d')];
                    return $query->whereBetween('period_of_report', $period);
                }

            })
            ->when($search, function ($query) use ($search) {
                $term = '%' . $search . '%';

                return $query->where('fund_symbol', 'ilike', $term);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Investor', 'formatted_name', 'fund_symbol')
                ->sortable()
                ->searchable(),

            Column::make('CIK', 'cik'),

            Column::make('Time', 'format_time', 'acceptance_time')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('fund_symbol')
            ->addColumn('formatted_name', function ($row) {
                $name = strtoupper($row->fund_symbol);
                $url = route('company.mutual-fund', $row->fund_symbol);
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$name}</a>";
            })
            ->addColumn('cik')
            ->addColumn('acceptance_time')
            ->addColumn('format_time', function ($row) {
                $time = $row->acceptance_time;
                return Carbon::parse($time)->diffForHumans();
            });
    }
}
