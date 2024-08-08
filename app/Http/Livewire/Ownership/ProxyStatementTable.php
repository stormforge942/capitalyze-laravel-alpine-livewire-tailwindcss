<?php

namespace App\Http\Livewire\Ownership;

use App\Models\SharesBeneficiallyOwned;
use App\Powergrid\BaseTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class ProxyStatementTable extends BaseTable
{
    public string $ticker;
    public array $filters = [];
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'filterOwnershipProxyStatementTable' => 'updateFilters',
        ]);
    }

    public function updateFilters(array $filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return SharesBeneficiallyOwned::query()
            ->where('symbol', '=', $this->ticker)
            ->when(data_get($this->filters, 'search'), function ($query) {
                $term = '%' . $this->filters['search'] . '%';

                return $query->where('company_name', 'ilike', $term);
            })
            ->select([
                'symbol',
                'cik',
                'company_name',
                'acceptance_time',
                'url',
                's3_url',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Company Name', 'company_name')->sortable(),
            Column::make('Acceptance Time', 'date', 'acceptance_time')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('HTML', 'html', 'acceptance_time')
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Data', 'form_data')
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('company_name')
            ->addColumn('date', function ($row) {
                if (!$row->acceptance_time) {
                    return '-';
                }

                return Carbon::parse($row->acceptance_time)->format('Y-m-d');
            })
            ->addColumn(
                'html',
                function ($row) {
                    return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `proxy-statement-slide`, { symbol: `' . $this->ticker . '`, acceptance_time: `' . $row->acceptance_time . '` })">Open</button>';
                }
            )
            ->addColumn(
                'form_data',
                function ($row) {
                    return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `s3-link-content`, { sourceLink: `' . $row->s3_url . '`, url: `' . $row->url . '`, highlightDates: true })">Open</button>';
                }
            )
            ->addColumn('securities_owned_following_transaction')
            ->addColumn('acceptance_time');
    }
}
