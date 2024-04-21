<?php

namespace App\Http\Livewire\Ownership;

use App\Powergrid\BaseTable;
use App\Models\CompanyInsider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use Illuminate\Contracts\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class CompanyInsidersTable extends BaseTable
{
    public string $ticker;
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public array $filters = [];

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'filterInsiderTransactionsTable' => 'updateFilters',
        ]);
    }

    public function updateFilters(array $filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return CompanyInsider::query()
            ->where('symbol', '=', $this->ticker)
            ->when(data_get($this->filters, 'search'), function ($query) {
                $term = '%' . $this->filters['search'] . '%';

                return $query->where('reporting_person', 'ilike', $term);
            })
            ->when(data_get($this->filters, 'transaction_codes'), function ($query) {
                return $query->whereIn('transaction_code', $this->filters['transaction_codes']);
            })
            ->when(data_get($this->filters, 'relationships'), function ($query) {
                $relationships = array_merge(...array_map(fn ($relationship) => config('insider_transactions_mapping')[$relationship] ?? [], $this->filters['relationships']));

                return $query->whereIn('relationship_of_reporting_person', $relationships);
            })
            ->when(data_get($this->filters, 'cso'), function ($query) {
                return $query->where('ownership_percentage', '<=', intval($this->filters['cso']));
            })
            ->when(data_get($this->filters, 'transaction_value'), function ($query) {
                $min = intval(data_get($this->filters, 'transaction_value.min')) * 1000;
                $max = intval(data_get($this->filters, 'transaction_value.max')) * 1000;

                return $query->whereBetween(DB::raw('amount_of_securities * price_per_security'), [$min, $max]);
            })
            ->when(data_get($this->filters, 'months'), function ($query) {
                $from = now()->subMonths($this->filters['months'])->startOfMonth()->toDateString();

                return $query->where('transaction_date', '>=', $from);
            })
            ->select([
                'reporting_person',
                'relationship_of_reporting_person',
                'transaction_code',
                'amount_of_securities',
                'price_per_security',
                'ownership_percentage',
                'market_cap',
                'transaction_date',
                'securities_owned_following_transaction',
                'url',
                'acceptance_time',
                DB::raw('amount_of_securities * price_per_security as value'),
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Insider Name', 'reporting_person')->sortable(),
            Column::make('Title', 'relationship_of_reporting_person')->sortable(),
            Column::make('Transaction', 'formatted_transaction_code', 'transaction_code'),
            Column::make('Reported Date', 'reported_date', 'acceptance_time')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Quantity', 'formatted_quantity', 'amount_of_securities')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Price',  'formatted_price', 'price_per_security')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Value', 'formatted_value', 'value')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Owned', 'formatted_owned', 'securities_owned_following_transaction')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('△Owned%', 'formatted_ownership_percent', 'ownership_percentage')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
            Column::make('Market Cap', 'market_cap_formatted', 'market_cap')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Transaction Date', 'transaction_date', 'transaction_date')->sortable()
                ->headerAttribute('[&>div]:justify-end')
                ->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('reporting_person')
            ->addColumn('relationship_of_reporting_person')
            ->addColumn('acceptance_time')
            ->addColumn('reported_date', function ($row) {
                if (!$row->acceptance_time) {
                    return '-';
                }

                return Carbon::parse($row->acceptance_time)->format('Y-m-d');
            })
            ->addColumn('transaction_code')
            ->addColumn(
                'formatted_transaction_code',
                function ($row) {
                    $result = config('capitalyze.transaction_code_map')[$row->transaction_code] ?? null;

                    if (!$result) return "-";

                    return $result['label'];
                }
            )
            ->addColumn('amount_of_securities')
            ->addColumn('price_per_security')
            ->addColumn('value')
            ->addColumn('securities_owned_following_transaction')
            ->addColumn('transaction_date')
            ->addColumn(
                'formatted_quantity',
                function ($row) {
                    if (is_null($row->amount_of_securities)) {
                        return '-';
                    }

                    return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `insider-transactions.form`, { url: `' . $row->url . '`, symbol: `' . $this->ticker . '`, quantity: ' . $row->amount_of_securities . ' })">' . number_format($row->amount_of_securities) . '</button>';
                }
            )
            ->addColumn('formatted_price', fn ($row) => is_null($row->price_per_security) ? '-' : number_format($row->price_per_security, 2))
            ->addColumn('formatted_value', fn ($row) => is_null($row->value) ? '-' : number_format($row->value))
            ->addColumn('formatted_owned', fn ($row) => is_null($row->securities_owned_following_transaction) ? '-' : number_format($row->securities_owned_following_transaction))
            ->addColumn(
                'formatted_ownership_percent',
                fn ($row) => is_null($row->ownership_percentage) ? '-' : round($row->ownership_percentage, 3) . '%'
            )
            ->addColumn(
                'market_cap_formatted',
                fn ($row) => is_null($row->market_cap) ? '-' : number_format($row->market_cap)
            );
    }
}
