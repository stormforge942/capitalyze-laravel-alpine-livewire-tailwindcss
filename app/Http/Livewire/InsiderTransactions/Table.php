<?php

namespace App\Http\Livewire\InsiderTransactions;

use App\Powergrid\BaseTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;

class Table extends BaseTable
{
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
    
    private function getLogoUrl($ticker)
    {
        if (Storage::disk('s3')->exists("company_logos/{$ticker}.png")) {
            return Storage::disk('s3')->url("company_logos/{$ticker}.png");
        } else {
            return asset('svg/logo.svg');
        }
    }

    public function datasource()
    {
        return DB::connection('pgsql-xbrl')
            ->table('insider_transactions')
            ->when(data_get($this->filters, 'search'), function ($query) {
                $value = $this->filters['search'];
                $term = '%' . $this->filters['search'] . '%';

                return $query->where(
                    fn ($q) => $q->where('symbol', strtoupper($value))
                        ->orWhere('registrant_name', 'ilike', $term)
                        ->orWhere('reporting_person', 'ilike', $term)
                );
            })
            ->when(data_get($this->filters, 'cso'), function ($query) {
                return $query->where('ownership_percentage', '<=', intval($this->filters['cso']));
            })
            ->when(data_get($this->filters, 'transaction_codes'), function ($query) {
                return $query->whereIn('transaction_code', $this->filters['transaction_codes']);
            })
            ->when(data_get($this->filters, 'relationships'), function ($query) {
                $relationships = array_merge(...array_map(fn ($relationship) => config('insider_transactions_mapping')[$relationship] ?? [], $this->filters['relationships']));

                return $query->whereIn('relationship_of_reporting_person', $relationships);
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
            Column::make('', 'logo')
                ->headerAttribute('[&>div]:w-[30px]'),
            Column::make('Company', 'company', 'symbol')->sortable(),
            Column::make('Insider Name', 'reporting_person')->sortable(),
            Column::make('Title', 'relationship_of_reporting_person'),
            Column::make('Transaction', 'formatted_transaction_code'),
            Column::make('Reported date', 'reported_date', 'acceptance_time')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
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

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('logo', function ($row) {
                $url = $this->getLogoUrl($row->symbol);
                return "<img src='{$url}' width='32' height='32' style='width: 32px;' />";
            })
            ->addColumn('symbol')
            ->addColumn('registrant_name')
            ->addColumn('company', function ($row) {
                $url = route('company.ownership', ['ticker' => $row->symbol, 'tab' => 'insider-transactions']);
                
                return "<a class=\"text-blue hover:underline\" href=\"{$url}\">{$row->symbol} <small>({$row->registrant_name})</small></a>";
            })
            ->addColumn('reporting_person')
            ->addColumn('relationship_of_reporting_person')
            ->addColumn('transaction_code')
            ->addColumn('amount_of_securities')
            ->addColumn('price_per_security')
            ->addColumn('value')
            ->addColumn('securities_owned_following_transaction')
            ->addColumn('transaction_date')
            ->addColumn('reported_date', function ($row) {
                if (!$row->acceptance_time) {
                    return '-';
                }

                return Carbon::parse($row->acceptance_time)->format('Y-m-d');
            })
            ->addColumn(
                'formatted_transaction_code',
                function ($row) {
                    $result = config('capitalyze.transaction_code_map')[$row->transaction_code] ?? null;

                    if (!$result) return "-";

                    return $result['label'];
                }
            )
            ->addColumn(
                'formatted_quantity',
                function ($row) {
                    if (is_null($row->amount_of_securities)) {
                        return '-';
                    }

                    return '<button type="button" class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded" onclick="Livewire.emit(`slide-over.open`, `insider-transactions.form`, { url: `' . $row->url . '`, symbol: `' . $row->symbol . '`, quantity: ' . $row->amount_of_securities . ' })">' . number_format($row->amount_of_securities) . '</button>';
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
