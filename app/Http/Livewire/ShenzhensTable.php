<?php

namespace App\Http\Livewire;

use App\Models\Shenzhens;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class ShenzhensTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    
    public bool $deferLoading = false; // default false
    public string $sortField = 'date';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public bool $displayLoader = true;
    public array $dateRange = [];
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
        $this->datasource();
    }

    public function setDateRange($dateRange)
    {
        $this->dateRange = $dateRange;

        // Extract dates from the $dateRange array
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        // Convert dates to a format that the database can understand
        $this->dateFilter = [
            Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s')
        ];

        $this->resetPage();
        $this->datasource();
    }

    public function datasource(): ?Builder
    {
        $query = Shenzhens::query();

        if (!empty($this->dateFilter)) {
            $query = $query->whereBetween('date', $this->dateFilter);
        }

        return $query;
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('symbol', function (Shenzhens $model) {
                return ("<a class='text-blue-500' href='/shenzhen/$model->symbol'>$model->symbol</a>");
            })
            ->addColumn('company_name')
            ->addColumn('date')
            ->addColumn('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Symbol', 'symbol')->sortable(),
            Column::make('Company Name', 'company_name')->sortable(),
            Column::make('Date', 'date')->sortable(),
            Column::make('Updated At', 'updated_at')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('symbol', 'symbol')->operators([]),
            Filter::inputText('company_name', 'company_name')->operators([]),
            Filter::inputText('date', 'date')->operators([]),
            Filter::inputText('updated_at', 'updated_at')->operators([]),
        ];
    }
}
