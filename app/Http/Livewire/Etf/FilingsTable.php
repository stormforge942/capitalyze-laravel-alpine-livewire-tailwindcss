<?php

namespace App\Http\Livewire\Etf;

use App\Models\EtfFilings;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};


final class FilingsTable extends PowerGridComponent
{
    use ActionButton;

    public string $sortField = 'acceptance_time';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];

    public array $dateFilter = [];

    public function setUp(): array
    {
        return [
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            ['dateRangeChanged' => 'setDateRange', 'dateRangeCleared' => 'clearDate']
        );
    }

    public function clearDate()
    {
        $this->dateFilter = [];
        $this->resetPage();
    }

    public function setDateRange($dateRange)
    {
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $this->dateFilter = [
            Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s')
        ];

        $this->resetPage();
    }

    public function datasource(): ?Builder
    {
        return EtfFilings::query()
            ->when(
                !empty($this->dateFilter),
                fn ($q) => $q->whereBetween('acceptance_time', $this->dateFilter)
            );
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('cik', function (EtfFilings $etf) {
                return ('<a href="' . route('etf.holdings', [$etf->cik, $etf->etf_symbol]) . '" class="break-all px-2 w-[80%] cursor-pointer text-blue">' . $etf->cik . '</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('CIK', 'cik')->sortable(),
            Column::make('Etf Symbol', 'etf_symbol')->sortable(),
            Column::make('Acceptance Time', 'acceptance_time')->sortable(),
            Column::make('Period Of Report', 'period_of_report')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('cik', 'cik')->operators([]),
            Filter::inputText('etf_symbol', 'etf_symbol')->operators([]),
            Filter::inputText('acceptance_time', 'acceptance_time')->operators([]),
            Filter::inputText('period_of_report', 'period_of_report')->operators([]),
        ];
    }
}
