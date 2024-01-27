<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\FundFilingsPage;
use App\Models\MutualFundsPage;
use App\Powergrid\BaseTable;
use Carbon\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use Illuminate\Database\Eloquent\Collection;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class MutualFundHistoryTable extends BaseTable
{
    public string $company;
    public array $fund;
    public string $sortField = 'period_of_report';
    public string $sortDirection = 'desc';

    public function mount(array $data = []): void
    {
        parent::mount();
    }

    public function datasource(): ?Collection
    {
        return MutualFundsPage::query()
            ->where($this->fund)
            ->where('symbol', $this->company)
            ->get();
    }

    public function columns(): array
    {
        return [
            Column::make('Effective Date', 'acceptance_time_formatted', 'acceptance_time')->sortable(),

            Column::make('Balance', 'formatted_balance', 'balance')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Market Value', 'market_vaue', 'val_usd')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('% of CSO', 'formatted_weight', 'weight')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Change in Balance', 'formatted_change_in_balance', 'change_in_balance')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Price Paid', 'price_paid', 'price_per_unit')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),

            Column::make('Position Date', 'period_of_report')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('acceptance_time')
            ->addColumn(
                'acceptance_time_formatted',
                fn ($fund) => Carbon::parse($fund->acceptance_time)->format('Y-m-d')
            )

            ->addColumn('balance')
            ->addColumn(
                'formatted_balance',
                fn ($fund) => redIfNegative($fund->balance, number_format(...))
            )

            ->addColumn('val_usd')
            ->addColumn(
                'market_vaue',
                fn ($fund) => redIfNegative($fund->val_usd, number_format(...))
            )

            ->addColumn('weight')
            ->addColumn(
                'formatted_weight',
                fn ($fund) => redIfNegative($fund->weight, fn ($val) => round($val, 4) . '%')
            )

            ->addColumn('change_in_balance')
            ->addColumn(
                'formatted_change_in_balance',
                fn ($fund) => redIfNegative($fund->change_in_balance, number_format(...))
            )

            ->addColumn('price_per_unit')
            ->addColumn(
                'price_paid',
                fn ($fund) => redIfNegative($fund->price_per_unit, fn ($val) => round($val, 4))
            )

            ->addColumn('period_of_report');
    }
}
