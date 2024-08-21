<?php

namespace App\Http\Livewire\CompanyProfile;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use App\Models\ExecutiveCompensation;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class ExecutiveCompensationTable extends BaseTable
{
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public array $config = [];
    public string $search = '';
    public $symbol;

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateExecutiveCompensationTable' => 'updateProps',
        ]);
    }

    public function updateProps(array $config, ?string $search)
    {
        $this->config = $config;
        $this->search = $search ?? '';

        $this->resetPage();
    }

    public function datasource()
    {
        return ExecutiveCompensation::query()
            ->when($this->symbol, fn ($q) => $q->where('symbol', $this->symbol))
            ->when($this->search, fn ($q) => $q->where('name_and_position', 'ilike', "%{$this->search}%"))
            ->orderByDesc('year');
    }

    public function columns(): array
    {
        return [
            Column::make('Current Position', 'name_and_position'),
            Column::make('year', 'year')->sortable(),
            Column::make('total', 'formatted_total', 'total')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('salary', 'formatted_salary', 'salary')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('bonus', 'formatted_bonus', 'bonus')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('stock_award', 'formatted_stock_award', 'stock_award')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('incentive_plan', 'formatted_incentive_plan', 'incentive_plan_compensation')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('other', 'formatted_other', 'all_other_compensation')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Date', 'filing_date')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('total')
            ->addColumn('formatted_total', function ($row) {
                if (is_null($row->total)) {
                    return '-';
                }

                return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `s3-link-html-content`, { url: `' . $row->s3_url . '`, sourceLink: `' . $row->url . '`, quantity: ' . $row->total . ' })">' . number_format($row->total) . '</button>';
            })
            ->addColumn('salary')
            ->addColumn('formatted_salary', fn ($row) => number_format($row->salary))
            ->addColumn('bonus')
            ->addColumn('formatted_bonus', fn ($row) => number_format($row->bonus))
            ->addColumn('stock_award')
            ->addColumn('formatted_stock_award', fn ($row) => number_format($row->stock_award))
            ->addColumn('incentive_plan_compensation')
            ->addColumn('formatted_incentive_plan', fn ($row) => number_format($row->incentive_plan_compensation))
            ->addColumn('all_other_compensation')
            ->addColumn('formatted_other', fn ($row) => number_format($row->all_other_compensation));
    }
}
