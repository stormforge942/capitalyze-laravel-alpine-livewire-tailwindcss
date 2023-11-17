<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Filing;
use App\Http\Livewire\AsTab;
use App\Powergrid\BaseTable;
use App\Services\OwnershipHistoryService;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use Illuminate\Contracts\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class History extends BaseTable
{
    use AsTab;

    public string $ticker;
    public string $cik;
    public string $sortField = 'report_calendar_or_quarter';
    public string $sortDirection = 'desc';

    public function mount(array $data = []): void
    {
        parent::mount();
        $this->ticker = OwnershipHistoryService::getCompany();
        $this->cik = $data['fund']['cik'];
    }

    public function datasource(): ?Builder
    {
        return Filing::query()
            ->select([
                'name_of_issuer',
                'report_calendar_or_quarter',
                'ssh_prnamt',
                'change_in_shares',
                'weight',
                'price_paid',
            ])
            ->where([
                'symbol' => $this->ticker,
                'cik' => $this->cik,
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name_of_issuer')->sortable(),
            Column::make('Date', 'report_calendar_or_quarter')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Shares Held or Principal Amt', 'ssh_prnamt')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Change in Shares', 'change_in_shares')
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('% of Portfolio', 'weight')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Estimated Avg Price Paid', 'price_paid')
                ->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('name_of_issuer')
            ->addColumn('report_calendar_or_quarter')
            ->addColumn('ssh_prnamt', function (Filing $filing) {
                return number_format($filing->ssh_prnamt);
            })
            ->addColumn('change_in_shares', function (Filing $filing) {
                if ($filing->change_in_shares >= 0) {
                    return number_format($filing->change_in_shares);
                }

                return '<span class="text-red">(' . number_format(-1 * $filing->change_in_shares) . ')</span>';
            })
            ->addColumn('weight', function (Filing $filing) {
                return number_format($filing->weight, 4) . '%';
            })
            ->addColumn('price_paid', function (Filing $filing) {
                return number_format($filing->price_paid, 4);
            });
    }
}
