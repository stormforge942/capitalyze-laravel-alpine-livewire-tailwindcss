<?php

namespace App\Http\Livewire\Ownership;

use App\Models\CompanyFilings;
use App\Powergrid\BaseTable;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use Illuminate\Database\Eloquent\Collection;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class FundHistoryTable extends BaseTable
{
    public ?string $company = '';
    public string $cik;
    public string $sortField = 'report_calendar_or_quarter';
    public string $sortDirection = 'desc';

    public function mount(array $data = []): void
    {
        parent::mount();
    }

    public function datasource(): ?Collection
    {
        return CompanyFilings::query()
            ->select([
                'report_calendar_or_quarter',
                'ssh_prnamt',
                'value',
                'weight',
                'change_in_shares',
                'change_in_shares_percentage',
                'price_paid',
                'signature_date',
            ])
            ->when($this->company, fn ($q) => $q->where('symbol', $this->company))
            ->where('cik', $this->cik)
            ->get();
    }

    public function columns(): array
    {
        return [
            Column::make('Effective Date', 'signature_date')->sortable(),
            Column::make('Common Stock Equivalent held', 'ssh_prnamt')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Market Value', 'value')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('% of CSO', 'weight')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Change in Shares', 'change_in_shares')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('%Change', 'change_in_shares_percentage')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Share Price', 'price_paid')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
            Column::make('Position Date', 'report_calendar_or_quarter')->sortable()
                ->headerAttribute('[&>div]:justify-end')->bodyAttribute('text-right'),
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('signature_date')
            ->addColumn('ssh_prnamt', function (CompanyFilings $filing) {
                return number_format($filing->ssh_prnamt);
            })
            ->addColumn('value', function (CompanyFilings $filing) {
                return number_format($filing->value);
            })
            ->addColumn('weight', function (CompanyFilings $filing) {
                return preg_replace('/\.?0+$/', '', number_format($filing->weight, 6)) . '%';
            })
            ->addColumn('change_in_shares', function (CompanyFilings $filing) {
                if ($filing->change_in_shares >= 0) {
                    return number_format($filing->change_in_shares);
                }

                return '<span class="text-red">(' . number_format(-1 * $filing->change_in_shares) . ')</span>';
            })
            ->addColumn('change_in_shares_percentage', function (CompanyFilings $filing) {
                if ($filing->change_in_shares_percentage >= 0) {
                    return round($filing->change_in_shares_percentage, 4);
                }

                return '<span class="text-red">(' . -1 * round($filing->change_in_shares_percentage, 4) . ')</span>';
            })
            ->addColumn('price_paid', function (CompanyFilings $filing) {
                return preg_replace('/\.?0+$/', '', number_format($filing->price_paid, 4));
            })
            ->addColumn('report_calendar_or_quarter');
    }
}
