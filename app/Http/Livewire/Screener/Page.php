<?php

namespace App\Http\Livewire\Screener;

use App\Models\CompanyProfile;
use App\Models\ScreenerTab;
use App\Services\ScreenerTableBuilderService;
use App\Services\TableBuilderService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Page extends Component
{
    protected $listeners = [
        'removeFinancialCriteria' => 'removeFinancialCriteria',
        'addFinancialCriteriaToSelected' => 'addFinancialCriteriaToSelected',
        'getScreenerResult' => 'getScreenerResult',
        'addFinancialCriteria' => 'addFinancialCriteria',
        'makeScreenerSummaryRows' => 'makeSummaryTableRows',
        'tabChanged' => 'tabChanged',
    ];

    protected $tabs = [
        'screenerData' => 'Screener Results',
        'quality' => 'Quality',
        'growth' => 'Growth',
        'risk' => 'Risk',
        'returnRatios' => 'Return Ratios',
        'marginAnalysis' => 'Margin Analysis'
    ];

    public $options = null;
    
    public $tableColumns = [];
    public $tableRows = [];
    public $summaryRows = [];

    public $activeTab;
    public $summaryPlacement = 'top';
    public $selectedFinancialCriteria = [];
    public $summaries = [];
    public $financialCriteriaCounters = [];

    public $page = 1;
    public $pageSize = 15;
    public $totalPageCount = 0;
    public $totalRecordCount = 0;

    public $locationsValue;
    public $stockExchangesValue;
    public $sectorsValue;
    public $industriesValue;
    public $currenciesValue;
    public $marketCapValue;
    public $decimalValue;

    public function render()
    {
        if (!$this->options) {
            $options = ['country', 'exchange', 'sic_group', 'sic_description', 'price_currency'];
            foreach ($options as $option) {
                $cacheKey = 'screener_criteria:' . $option;
                $this->options[$option] = Cache::remember(
                    $cacheKey,
                    now()->addHour(),
                    fn() => CompanyProfile::select($option)
                        ->distinct()
                        ->whereNotNull($option)
                        ->pluck($option)
                        ->toArray()
                );
            }
        }

        return view('livewire.screener.page', [
            'tabs' => $this->tabs,
            'activeTab' => $this->activeTab,
            '$selectedFinancialCriteria' => $this->selectedFinancialCriteria,
            'allMetrics' => TableBuilderService::options(true),
            'summaries' => $this->summaries,
            'tableRows' => $this->tableRows,
            'summaryRows' => $this->summaryRows,
            'tableColumns' => $this->tableColumns,
        ]);
    }

    public function getFinancialCriteriaDataProperty()
    {
        return ScreenerTableBuilderService::resolveData(['AAPL'] ?? []);
    }

    public function removeFinancialCriteria(string $id): void
    {
        if (count($this->selectedFinancialCriteria) < 2) {
            $this->selectedFinancialCriteria = [];

            $this->addFinancialCriteria();

            return;
        }

        $this->selectedFinancialCriteria = array_values(array_filter($this->selectedFinancialCriteria, function ($item) use ($id) {
            return $item['id'] !== $id;
        }));
    }

    public function addFinancialCriteria(): void
    {
        $criteria['id'] = uniqid();
        $criteria['value'] = [];

        $this->selectedFinancialCriteria[] = $criteria;
    }

    public function addFinancialCriteriaToSelected($data): void
    {
        foreach ($data as $item) {
            $criteria['id'] = uniqid();
            $criteria['value'] = [$item];

            $this->selectedFinancialCriteria[] = $criteria;
        }
    }

    public function getScreenerResult($universeCriteria = null, $financialCriteria = null)
    {
        $presetType = $this->activeTab;

        if ($presetType === 'screenerData' && $this->checkFinancialCriteria($financialCriteria ?? $this->selectedFinancialCriteria)) {
            $this->buildTable($universeCriteria, $financialCriteria ?? $this->selectedFinancialCriteria);
            $this->updateTab($universeCriteria, $financialCriteria);

            return;
        }

        if ($presetType === 'screenerData' && !$this->checkFinancialCriteria($financialCriteria ?? $this->selectedFinancialCriteria)) {
            $this->tableColumns = [];
            $this->tableRows = [];

            return;
        }

        $this->buildTableFromPreset(new ScreenerTableBuilderService(), $universeCriteria);

        $this->updateTab($universeCriteria, $financialCriteria);
    }

    public function buildTableFromPreset(ScreenerTableBuilderService $screenerTableBuilderService, $universeCriteria): void
    {
        $presetType = $this->activeTab;
        $financialCriteria = $screenerTableBuilderService->getPresetCriteria($presetType);

        $this->buildTable($universeCriteria, $financialCriteria);
    }

    public function buildTable($universeCriteria = null, $financialCriteria = null): void
    {
        $screenerTableService = new ScreenerTableBuilderService();

        $this->tableData = $screenerTableService->resolveDataTest($universeCriteria, $financialCriteria);

        if (count($this->tableData) < 1) {
            return;
        }

        $this->tableColumns = $this->makeTableColumns($this->tableData[0]);
        $this->tableRows = $this->paginateTableRows($this->tableData);

        $this->emit('refreshFinancialCriteriaCounter', $this->financialCriteriaCounters);

        $this->makeSummaryTableRows($this->summaries);
    }

    private function formatFinancialCriteria($data)
    {
        if (!isset($data)) {
            return null;
        }

        if (isset($data[0]['value']) && empty($data[0]['value'])) {
            return null;
        }

        if (isset($data[0]['value'])) {
            return array_map(function ($item) {
                return $item['value'][0];
            }, $data);
        }

        return $data;
    }

    private function makeTableColumns(array $tableRow)
    {
        $tableColumns = [];
        $tableColumnsLabelMap = [
            'ticker' => 'Ticker',
            'registrant_name' => 'Name'
        ];

        $excludeColumnsMap = [
            'country',
            'sic_group',
            'sic_description',
            'exchange'
        ];

        foreach ($tableRow as $key => $value) {
            if (in_array($key, $excludeColumnsMap)) {
                continue;
            }

            if (str_starts_with($key, 'counter')) {
                $financialCriteriaKey = explode('_', $key)[1];
                $this->financialCriteriaCounters[$financialCriteriaKey] = $value;
                continue;
            }

            if (isset($tableColumnsLabelMap[$key])) {
                $tableColumns[] = ['label' => $tableColumnsLabelMap[$key], 'key' => $key];
                continue;
            }

            $tableColumns[] = ['label' => $key, 'key' => $key];
        }

        return $tableColumns;
    }

    private function makeTableRows($tableData)
    {
        return $tableData;
    }

    public function tabChanged($tab)
    {
        $this->tab = $tab;

        $screenerTab = ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->where('id', $tab['id'])
            ->first();

        $this->tableColumns = [];
        $this->tableRows = [];

        $this->locationsValue = $screenerTab->locations;
        $this->stockExchangesValue = $screenerTab->stock_exchanges;
        $this->sectorsValue = $screenerTab->sectors;
        $this->industriesValue = $screenerTab->industries;
        $this->currenciesValue = $screenerTab->currencies;
        $this->decimalValue = $screenerTab->decimal;

        $this->selectedFinancialCriteria = $screenerTab->selected_financial_criteria;
        $this->activeTab = $screenerTab->screener_view_name;

        $universeCriteria = [
            'locations' => $this->locationsValue,
            'stockExchanges' => $this->stockExchangesValue,
            'sectors' => $this->sectorsValue,
            'industries' => $this->industriesValue,
            'currencies' => $this->currenciesValue,
        ];

        $this->getScreenerResult($universeCriteria, $this->selectedFinancialCriteria);
    }

    public function updateTab($universeCriteria, $financialCriteria)
    {
        $screenerTab = ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->first();

        $screenerTab->update([
            'locations' => $universeCriteria['locations'],
            'stock_exchanges' => $universeCriteria['stockExchanges'],
            'industries' => $universeCriteria['industries'],
            'sectors' => $universeCriteria['sectors'],
            'summaries' => $this->summaries,
            'selected_financial_criteria' => $financialCriteria,
            'screener_view_name' => $this->activeTab,
        ]);
    }

    public function checkFinancialCriteria($financialCriteria): bool
    {
        foreach ($financialCriteria as $key => $criterion) {
            if (count($criterion['value']) < 1) {
                return false;
            }
        }

        return true;
    }

    public function makeSummaryTableRows($summaries): void
    {
        $excludeColumnsMap = [
            'ticker' => 'Ticker',
            'registrant_name' => 'Name'
        ];

        $tableRows = $this->tableRows;
        $tableColumns = array_filter($this->tableColumns, function ($item) use ($excludeColumnsMap) {
            return !isset($excludeColumnsMap[$item['key']]);
        });
        $this->summaries  = $summaries;

        if (empty($tableRows)) {
            return;
        }

        $summaryHandler = [
            'Max' => function ($values) {
                $values = array_filter($values, fn($value) => $value !== 'N/A');

                if (empty($values)) {
                    return '-';
                }

                return max($values);
            },
            'Min' => function ($values) {
                $values = array_filter($values, fn($value) => $value !== 'N/A');

                if (empty($values)) {
                    return '-';
                }

                return min($values);
            },
            'Sum' => function ($values) {
                $values = array_filter($values, fn($value) => $value !== 'N/A');

                if (empty($values)) {
                    return '-';
                }

                return array_sum($values);
            },
            'Median' => function ($values) {
                $values = array_filter($values, fn($value) => $value !== 'N/A');

                if (empty($values)) {
                    return '-';
                }

                sort($values);
                $count = count($values);
                $middleIndex = floor($count / 2);

                if ($count % 2) {
                    return $values[$middleIndex];
                } else {
                    return ((int)$values[$middleIndex - 1] + (int)$values[$middleIndex]) / 2;
                }
            }
        ];

        $summaryRows = array_map(function ($summary) use ($tableRows, $tableColumns, $summaryHandler) {
            $row = [
                'title' => strtoupper($summary),
                'columns' => []
            ];

            foreach ($tableColumns as $col) {
                $values = array_filter(array_map(fn($row) => $row[$col['label']] ?? null, $tableRows), fn($v) => $v !== null);

                $row['columns'][$col['label']] = $summaryHandler[$summary]($values);
            }

            return $row;
        }, $summaries);


        $this->summaryRows = $summaryRows;
    }

    private function paginateTableRows(array $tableRows)
    {
        $this->totalRecordCount = count($tableRows);
        $this->totalPageCount = ceil($this->totalRecordCount / $this->pageSize);

        $offset = ($this->page - 1) * $this->pageSize;

        $data = array_slice($tableRows, $offset, $this->pageSize);

        return $data;
    }

    public function prevPage()
    {
        if ($this->page > 1) {
            $this->page = $this->page - 1;
            $this->tableRows = $this->paginateTableRows($this->tableData);
        }
    }

    public function nextPage()
    {
        if ($this->page < $this->totalPageCount) {
            $this->page = $this->page + 1;
            $this->tableRows = $this->paginateTableRows($this->tableData);
        }
    }

    public function goToPage($destination)
    {
        $this->page = (int)$destination;
        $this->tableRows = $this->paginateTableRows($this->tableData);
    }
}
