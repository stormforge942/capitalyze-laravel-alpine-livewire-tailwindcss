<?php

namespace App\Http\Livewire\AllFilings;

use App\Powergrid\BaseTable;
use App\Models\CompanyLinks;
use PowerComponents\LivewirePowerGrid\Column;
use Illuminate\Contracts\Database\Query\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class FilingsTable extends BaseTable {
    public $checkedCount;
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public string $search = '';
    public array $filtered;
    public $company;
    public $selectedTab;
    public $dateSortOrder;
    public $selectChecked = [];
    public $col = 'acceptance_time';
    public $order = 'desc';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), ['updateDateSortOrder', 'updateSearch', 'updateFilteredEvent']);
    }

    public function updateFilteredEvent($formTypes): void
    {
        $this->selectChecked = $formTypes;
    }

    public function updateSearch($searchTxt): void
    {
        $this->search = $searchTxt;
    }

    public function updateDateSortOrder($order): void
    {
        if (!empty($order)) {
            $this->dateSortOrder = $order;
            $this->sortField = 'filing_date';
            $this->sortDirection = $order;
        }
    }

    public function datasource(): ?Builder
    {
        $query = CompanyLinks::query()
            ->where('symbol', $this->company->ticker)
            ->when($this->search, function($query, $search) {
                return $query->where(function($subQuery) use ($search) {
                    $subQuery->where('form_type', 'ilike', "%$search%")->orWhere('description', 'ilike', "%$search%");
                });
            });

        if (!empty($this->selectChecked)) {
            $query = $query->whereIn('form_type', $this->selectChecked);
        } else if (!empty($this->filtered)){
            $query = $query->whereIn('form_type', $this->filtered);
        }

        return $query;
    }

    public function columns(): array
    {
        return [
            Column::make('File name', 'form_type')
                ->sortable(),
            Column::make('Description', 'description'),
            Column::make('Filing Date', 'filing_date')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Acceptance Time', 'acceptance_time')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('form_type', function ($row) {
                return $row->form_type . '<div class="row-data" data-row="' . htmlspecialchars(json_encode($row)) . '"></div>';
            });
    }
}
