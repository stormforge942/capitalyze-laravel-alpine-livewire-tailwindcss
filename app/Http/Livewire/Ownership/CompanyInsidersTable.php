<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use App\Powergrid\BaseTable;
use App\Models\CompanyInsider;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use Illuminate\Contracts\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class CompanyInsidersTable extends BaseTable
{
    use AsTab;

    public string $ticker;
    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';

    public static function title(): string
    {
        return 'Company Insiders';
    }

    public function datasource(): ?Builder
    {
        $query = CompanyInsider::query()
            ->where('symbol', '=', $this->ticker);

        return $query;
    }

    public function columns(): array
    {
        return [
            Column::make('Insider Name', 'reporting_person')->sortable(),
            Column::make('Title', 'relationship_of_reporting_person')->sortable(),
            Column::make('Reporting CIK', 'reporting_cik')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Transaction', 'formatted_transaction_code', 'transaction_code'),
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
            ->addColumn('reporting_cik')
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
            ->addColumn('formatted_quantity', fn ($row) => is_null($row->amount_of_securities) ? '-' : number_format($row->amount_of_securities))
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
