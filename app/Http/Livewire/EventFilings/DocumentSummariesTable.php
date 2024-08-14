<?php

namespace App\Http\Livewire\EventFilings;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class DocumentSummariesTable extends BaseTable
{
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public array $config = [];
    public string $search = '';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateDocumentSummariesTable' => 'updateProps',
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
            ->table('document_summaries')
            ->when($this->search, fn ($q) => $q->where('symbol', 'ilike', "%{$this->search}%"));
    }

    public function columns(): array
    {
        return [
            Column::make('Symbol', 'formatted_symbol', 'symbol')->sortable()->bodyAttribute('w-[5rem]'),
            Column::make('Filing Type', 'formatted_form_type', 'form_type')->sortable()->bodyAttribute('w-[5rem]'),
            Column::make('Summary', 'formatted_summary', 'summary')->bodyAttribute('max-w-[20rem]'),
            Column::make('Filing Date', 'filing_date')->sortable()->bodyAttribute('w-[10rem]'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('registrant_name')
            ->addColumn('formatted_symbol', function ($row) {
                $url = route('company.profile', $row->symbol);
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$row->symbol}</a>";
            })
            ->addColumn('form_type')
            ->addColumn('formatted_form_type', function ($row) {
                return '<button class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" @click="Livewire.emit(`slide-over.open`, `document-summary-content`, { sourceLink: `' . $row->s3_link . '`, symbol: `' . $row->symbol . '`, date: `' . $row->filing_date . '`})">' . $row->form_type . '</button>';
            })
            ->addColumn('summary')
            ->addColumn('formatted_summary', function ($row) {
                $summary = htmlspecialchars($row->summary); // Encode HTML entities to prevent XSS
                return '<span class="inline-block w-full whitespace-nowrap overflow-hidden text-ellipsis">' . $summary . '</span>';
            })
            ->addColumn('filing_date');
    }
}
