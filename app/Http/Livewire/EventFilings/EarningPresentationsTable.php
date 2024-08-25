<?php

namespace App\Http\Livewire\EventFilings;

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
    public string $search = '';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateEarningPresentationsTable' => 'updateProps',
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
        return DB::connection('pgsql-xbrl')
            ->table('earning_presentations')
            ->when($this->search, fn ($q) => $q->where('registrant_name', 'ilike', "%{$this->search}%"))
            ->orderBy('fiscal_year', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('Company Name', 'company', 'registrant_name'),
            Column::make('Result', 'formatted_result', 's3_url'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('registrant_name')
            ->addColumn('company', function ($row) {
                $url = route('company.profile', $row->symbol);
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$row->registrant_name}</a>";
            })
            ->addColumn('s3_url')
            ->addColumn('formatted_result', function ($row) {
                return '<button class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" @click="Livewire.emit(`slide-over.open`, `earning-presentation-content`, { sourceLink: `' . $row->s3_url . '` })">' . $row->fiscal_year . ' ' . $row->fiscal_period . ' Presentation</button>';
            });
    }
}
