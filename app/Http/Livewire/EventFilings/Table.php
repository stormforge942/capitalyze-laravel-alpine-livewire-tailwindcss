<?php

namespace App\Http\Livewire\EventFilings;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class Table extends BaseTable
{
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public array $config = [];
    public string $search = '';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'updateEventFilingsTable' => 'updateProps',
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
            ->table('company_links')
            ->when(isset($this->config['in']), function ($query) {
                $in = [];

                foreach ($this->config['in'] as $item) {
                    $in[] = $item;
                    $in[] = $item . '/A';
                }

                $query->whereIn('form_type', $in);
            })
            ->when($this->search, fn ($q) => $q->where('registrant_name', 'ilike', "%{$this->search}%"));
    }

    public function columns(): array
    {
        return [
            Column::make('Company Name', 'company', 'registrant_name')->sortable(),
            Column::make('Filing Type', 'formatted_form_type', 'form_type')->sortable(),
            Column::make('Description', 'description'),
            Column::make('Filing Date', 'filing_date')->sortable(),
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
            ->addColumn('form_type')
            ->addColumn('formatted_form_type', function ($row) {
                return '<button class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" @click="Livewire.emit(`slide-over.open`, `s3-link-content`, { sourceLink: `' . $row->s3_link . '`, url: `' . $row->final_link . '` })">' . $row->form_type . '</button>';
            })
            ->addColumn('description')
            ->addColumn('filing_date');
    }
}
