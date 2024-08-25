<?php

namespace App\Http\Livewire\FilingsSummary;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class EarningPresentations extends BaseTable
{
    public string $sortField = 'fiscal_period';
    public string $sortDirection = 'asc';
    public $ticker = null;
    public array $config = [];
    public string $search = '';

    public function datasource()
    {
        return DB::connection('pgsql-xbrl')
            ->table('earning_presentations')
            ->where('symbol', '=', $this->ticker)
            ->when($this->search, fn ($q) => $q->where('registrant_name', 'ilike', "%{$this->search}%"))
            ->orderBy('fiscal_year', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('Period', 'period'),
            Column::make('Source URL', 'formatted_source_url', 'source_url'),
            Column::make('Result', 'formatted_result', 'presentation_url'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('period', function ($row) {
                return "<span>{$row->fiscal_year} {$row->fiscal_period}</span>";
            })
            ->addColumn('source_url')
            ->addColumn('formatted_source_url', function ($row) {
                return '<a href="' . $row->source_url . '" target="_blank" class="text-blue-500 hover:underline">' . $row->source_url . '</a>';
            })
            ->addColumn('presentation_url')
            ->addColumn('formatted_result', function ($row) {
                return '<button class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" @click="Livewire.emit(`slide-over.open`, `earning-presentation-content`, { sourceLink: `' . $row->presentation_url . '` })">Show PDF</button>';
            });
    }
}
