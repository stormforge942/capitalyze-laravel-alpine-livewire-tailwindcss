<?php

namespace App\Http\Livewire\CompanyReport;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class EarningPresentationsTable extends BaseTable
{
    public string $sortField = 'fiscal_period';
    public string $sortDirection = 'desc';
    public array $config = [];
    public string $ticker = '';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateCompanyReportEarningPresentationTable' => 'updateProps',
        ]);
    }

    public function updateProps(array $config, ?string $ticker)
    {
        $this->config = $config;
        $this->ticker = $ticker ?? '';

        $this->resetPage();
    }

    public function datasource()
    {
        return DB::connection('pgsql-xbrl')
            ->table('earning_presentations')
            ->where('symbol', $this->ticker)
            ->orderBy('fiscal_year', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('Result', 'formatted_result', 's3_url'),
            Column::make('Source Url', 'source_url'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('formatted_result', function ($row) {
                return '<button class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" @click="Livewire.emit(`slide-over.open`, `earning-presentation-content`, { sourceLink: `' . $row->s3_url . '` })">' . $row->fiscal_year . ' ' . $row->fiscal_period . ' Presentation</button>';
            })
            ->addColumn('source_url', function ($row) {
                return '<a target="_blank" class="text-blue hover:underline" href="' . $row->source_url . '">' . $row->source_url . '</a>';
            });
    }
}
