<?php

namespace App\Http\Livewire\InsiderTransactions;

use App\Powergrid\BaseTable;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class Table extends BaseTable
{
    public string $sortField = 'transaction_date';
    public string $sortDirection = 'asc';
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

    public function datasource()
    {
        return DB::connection('pgsql-xbrl')
            ->table('insider_transactions')
            ->when(data_get($this->filters, 'search'), function ($query) {
                $value = $this->filters['search'];
                $term = '%' . $this->filters['search'] . '%';

                return $query->where(
                    fn ($q) => $q->where('symbol', $value)
                        ->orWhere('registrant_name', 'ilike', $term)
                        ->orWhere('reporting_person', 'ilike', $term)
                );
            })
            ->when(data_get($this->filters, 'transaction_codes'), function ($query) {
                return $query->whereIn('transaction_code', $this->filters['transaction_codes']);
            })
            ->when(data_get($this->filters, 'relationships'), function ($query) {
                return $query->whereIn('relationship_of_reporting_person', $this->filters['relationships']);
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
                'symbol',
                'registrant_name',
                'reporting_person',
                'relationship_of_reporting_person',
                'transaction_code',
                'amount_of_securities',
                'price_per_security',
                'securities_owned_following_transaction',
                DB::raw('amount_of_securities * price_per_security as value'),
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Ticker', 'ticker', 'symbol')->sortable(),
            Column::make('Company', 'registrant_name')->sortable(),
            Column::make('Insider Name', 'reporting_person')->sortable(),
            Column::make('Title', 'relationship_of_reporting_person'),
            Column::make('Transaction', 'formatted_transaction_code'),
            Column::make('Quantity', 'formatted_quantity', 'amount_of_securities')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Price',  'formatted_price', 'price_per_security')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Value', 'formatted_value', 'value')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Owned', 'formatted_owned', 'securities_owned_following_transaction')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('△Owned%', 'blank')
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Market Cap', 'blank')
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('symbol')
            ->addColumn('registrant_name')
            ->addColumn('ticker', function($row) {
                $url = route('company.profile', $row->symbol);
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$row->symbol}</a>";
            })
            ->addColumn('reporting_person')
            ->addColumn('relationship_of_reporting_person')
            ->addColumn('transaction_code')
            ->addColumn('amount_of_securities')
            ->addColumn('price_per_security')
            ->addColumn('value')
            ->addColumn('securities_owned_following_transaction')
            ->addColumn('blank', fn () => '-')
            ->addColumn(
                'formatted_transaction_code',
                function ($row) {
                    $result = config('capitalyze.transaction_code_map')[$row->transaction_code] ?? null;

                    if (!$result) return "-";

                    return $result['label'];
                }
            )
            ->addColumn('formatted_quantity', fn ($row) => is_null($row->amount_of_securities) ? '-' : number_format($row->amount_of_securities))
            ->addColumn('formatted_price', fn ($row) => is_null($row->price_per_security) ? '-' : number_format($row->price_per_security, 2))
            ->addColumn('formatted_value', fn ($row) => is_null($row->value) ? '-' : number_format($row->value))
            ->addColumn('formatted_owned', fn ($row) => is_null($row->securities_owned_following_transaction) ? '-' : number_format($row->securities_owned_following_transaction));
    }
}
