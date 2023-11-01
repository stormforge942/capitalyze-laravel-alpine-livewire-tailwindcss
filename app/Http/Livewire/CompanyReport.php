<?php

namespace App\Http\Livewire;

use App\Models\InfoPresentation;
use App\Models\InfoTikrPresentation;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CompanyReport extends Component
{
    use TableFiltersTrait;


    public $rows = [];
    public $company;
    public $decimalDisplay = '0';
    public $ticker;
    public $chartData = [];
    public $companyName;
    public $unitType = 'Thousands';
    public $currency = 'USD';
    public $currentRoute;
    public $order = "Latest on the Right";
    public $period;
    public $table;
    public $navbar;
    public $reverse = false;
    public $activeIndex = '';
    public $activeSubIndex = '';
    public $data;
    public $tableDates = [];
    public $rangeDates = [];
    public $noData = false;
    public $tableLoading = true;

    protected $request;
    protected $rowCount = 0;
    public $selectedRows = [];
    public $selectedValue = [];
    public $chartType = 'line';
    public $isOpen = false;

    protected $listeners = ['periodChange', 'tabClicked', 'tabSubClicked', 'selectRow', 'unselectRow'];

    public function toggleChartType($title)
    {
        if ($this->isOpen === $title) {
            $this->isOpen = null;
        } else {
            $this->isOpen = $title;
        }


    }

    public function selectRow($title, $data)
    {
        if (count($this->selectedRows) < 5) {
            $this->selectedRows[$title]['dates'] = $data;
            $this->selectedRows[$title]['type'] = 'line';
        }

        $this->generateChartData();
        $this->emit('initCompanyReportChart');
    }

    public function regenerateTableChart(): void
    {
        $this->generateUI();
    }

    public function unselectRow($title)
    {
        unset($this->selectedRows[$title]);
        $this->emit('resetSelection', $title);

        if (count($this->selectedRows)) {
            $this->generateChartData(true);
        } else {
            $this->chartData = [];
            $this->emit('hideCompanyReportChart');
        }
    }

    public function toggleReverse()
    {
        $this->reverse = !$this->reverse;
        $this->regenerateTableChart();
    }

    public function changeChartType($title, $type)
    {
        $this->selectedRows[$title]['type'] = $type;

        $this->chartType = $type;

        $this->generateChartData();
    }

    public function generateChartData($initChart = false): void
    {
        $chartData = [];
        foreach ($this->selectedRows as $title => $row) {
            $data = [];
            foreach ($row['dates'] as $cell) {
                if (!$cell['empty']) {
                    $data[] = [
                        'y' => $cell['value'],
                        'x' => $cell['date'],
                    ];
                } else {
                    $data[] = [
                        'y' => null,
                        'x' => null,
                    ];
                }
            }

            $chartData[] = [
                'data' => $data,
                'type' => $row['type'],
                'label' => $title,
                'borderColor' => ['#5a5a5a', '#737373', '#8d8d8d', '#a6a6a6', '#949494'],
                'pointRadius' => 1,
                'pointHoverRadius' => 8,
                'tension' => 0.5,
                'fill' => true,
                'pointHoverBorderColor' => '#fff',
                'pointHoverBorderWidth' => 4,
                'pointHoverBackgroundColor' => 'rgba(104, 104, 104, 0.87)'
            ];
        }

        $this->chartData = $chartData;

        if ($initChart) {
            $this->emit('initCompanyReportChart');
        }
    }

    public function getData()
    {
        $acronym = ($this->period == 'annual') ? 'arf5drs' : 'qrf5drs';

        $defaultConnectionName = DB::getDefaultConnection();
        $defaultConnectionResolver = new ConnectionResolver();
        $defaultConnectionResolver->addConnection(
            $defaultConnectionName,
            DB::connection($defaultConnectionName),
        );
        $defaultConnectionResolver->setDefaultConnection($defaultConnectionName);

        $remoteConnectionName = 'pgsql-xbrl';
        $remoteConnectionResolver = new ConnectionResolver();
        $remoteConnectionResolver->addConnection(
            $remoteConnectionName,
            DB::connection($remoteConnectionName),
        );
        $remoteConnectionResolver->setDefaultConnection($remoteConnectionName);

        DB::setDefaultConnection($remoteConnectionName);
        Model::setConnectionResolver($remoteConnectionResolver);

        if ($this->view === 'Common Size') {
            $query = InfoPresentation::query()
                ->where('ticker', '=', $this->ticker)
                ->where('acronym', '=', $acronym)
                ->where('id', '=', $this->activeSubIndex)
                ->select('info')->value('info');
        }

        if ($this->view === 'Standardised Template') {
            $query = InfoTikrPresentation::query()
                ->where('ticker', '=', $this->ticker)
                ->select('info')->value('info');
        }

        Model::setConnectionResolver($defaultConnectionResolver);
        DB::setDefaultConnection($defaultConnectionName);

        $data = json_decode($query, true);
        $this->data = $data;
        $this->generateUI();
    }

    public function closeChart()
    {
        $this->chartData = [];
        $this->selectedRows = [];
        $this->emit('hideCompanyReportChart');
    }

    public function changeDates($dates)
    {
        $this->tableLoading = true;
        $this->rows = [];
        if ($this->period === 'annual') {
            if (count($dates) == 2) {
                $this->tableDates = [];

                if (gettype($dates[0]) === 'integer') {
                    $date = new DateTime($dates[0] . '-09-09');
                    $dates[0] = $date->format('Y-m-d');
                }

                if (gettype($dates[1]) === 'integer') {
                    $date = new DateTime($dates[1] . '-09-09');
                    $dates[1] = $date->format('Y-m-d');
                }

                $minYear = strtotime($dates[0]);
                $maxYear = strtotime($dates[1]);
                $year = 365 * 24 * 60 * 60;

                for ($currentDate = $minYear; $currentDate <= $maxYear; $currentDate += $year) {
                    $this->tableDates[] = date('Y-m-d', $currentDate);
                }
            }
        }

        if ($this->period === 'quarterly') {

            $this->tableDates = array_unique($this->tableDates);

            $filteredDates = array_filter($this->tableDates, function ($date) use ($dates) {
                $year = intval(date('Y', strtotime($date)));
                return $year >= $dates[0] && $year <= $dates[1];
            });

            $this->tableDates = $filteredDates;
        }

        $this->generateRows($this->data);

        if (count($this->selectedRows)) {
            $this->generateChartData();
            $this->emit('initCompanyReportChart');
        }
        $this->tableLoading = false;
    }

    public function generateUI(): void
    {
        $this->generateTableDates();
        $this->generateRows($this->data);
    }

    function traverseArray($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (strtotime($key) !== false) {
                    $this->tableDates[] = date('Y-m-d', strtotime($key));
                }
                $this->traverseArray($value);
            } else {
                break;
            }
        }
    }

    public function generateTableDates()
    {
        $this->traverseArray($this->data);

        $dates = [];
        $minYear = strtotime(min(array_unique($this->tableDates)));
        $maxYear = strtotime(max(array_unique($this->tableDates)));
        $year = 365 * 24 * 60 * 60;

        for ($currentDate = $minYear; $currentDate <= $maxYear; $currentDate += $year) {
            $dates[] = date('Y-m-d', $currentDate);
        }

        $this->rangeDates = $dates;

        if (count($this->rangeDates) > 0) {
            if ($this->rangeDates[0] > $this->rangeDates[count($this->rangeDates) - 1]) {
                $this->rangeDates = array_reverse($this->rangeDates);
            }

            $this->selectedValue = [$this->rangeDates[0], $this->rangeDates[count($this->rangeDates) - 1]];
        }

        $rangeMax = strtotime($this->selectedValue[1]) ?: strtotime(now());
        $this->selectedValue[0] = date('Y-m-d', $rangeMax - 6 * 365 * 24 * 60 * 60);
        $this->changeDates($this->selectedValue);
    }

    public function generateRows($data)
    {
        $this->tableLoading = true;
        $rows = [];

        if ($this->view === 'Common Size') {
            if (
                isset($data['Income Statement']) &&
                is_array($data['Income Statement']) &&
                isset($data['Income Statement']['Statement']) &&
                is_array($data['Income Statement']['Statement']) &&
                isset($data['Income Statement']['Statement']['Statement'])
            ) {
                $data = $data['Income Statement']['Statement']['Statement'];
            }

            if (
                isset($data['Statement of Financial Position']) &&
                is_array($data['Statement of Financial Position'])
            ) {
                $data = $data['Statement of Financial Position'];
            }

            if (
                isset($data['Statement of Cash Flows']) &&
                is_array($data['Statement of Cash Flows'])
            ) {
                $data = $data['Statement of Cash Flows'];
            }
        }

        if ($this->view === 'Standardised Template') {
            if ($this->period === 'annual') {
                $data = $data['annual'];
            }

            if ($this->period === 'quarterly') {
                $data = $data['quarterly'];
            }
            foreach ($this->navbar[$this->activeIndex] as $tab) {
                if ($tab['id'] === $this->activeSubIndex) {
                    $data = match ($tab['title']) {
                        'Income Statement' => $data['Income Statement'],
                        'Balance Sheet Statement' => $data['Balance Sheet'],
                        'Cash Flow Statement' => $data['Cash Flow Statement'],
                        default => $data
                    };
                }
            }
        }

        foreach ($data as $key => $value) {
            $rows[] = $this->generateRow($value, $key);

        }

        $this->rows = $rows;
        $this->tableLoading = false;
    }

    public function generateRow($data, $title, $isSegmentation = false): array
    {
        $row = [
            'title' => $title,
            'segmentation' => false,
            'values' => $this->generateEmptyCellsRow(),
            'children' => [],
        ];

        foreach ($data as $key => $value) {
            $isDate = true;
            try {
                Carbon::createFromFormat('Y-m-d', $key);
            } catch (\Exception $e) {
                $isDate = false;
            }

            if ($isDate) {
                $year = Carbon::createFromFormat('Y-m-d', $key)->format('Y-m');

                foreach ($this->tableDates as $date) {
                    $datePart = substr($date, 0, 7);
                    if ($datePart == $year) {
                        $row['values'][$date] = $this->parseCell($value, $key);
                        break;
                    }
                }
            } else {
                if (in_array($key, ['#segmentation'])) {
                    foreach ($value as $sKey => $sValue) {
                        $keyn = array_keys($value[$sKey])[0];
                        $valuen = $sValue[$keyn];
                        $keynn = array_keys($valuen)[0];
                        $valuenn = $valuen[$keynn];
                        $row['children'][] = $this->generateRow($valuenn, $keynn, true);
                    }
                } else {
                    $row['children'][] = $this->generateRow($value, $key, $isSegmentation);
                }
            }

        }

        $row['segmentation'] = $isSegmentation && count($row['children']) === 0;
        $row['id'] = serialize($row);

        return $row;
    }

    public function generatePresent($value)
    {
        $unitType = $this->unitType;
        $units = [
            'Thousands' => 'T',
            'Millions' => 'M',
            'Billions' => 'B',
        ];

        $decimalDisplay = intval($this->decimalDisplay);

        if (str_contains($value, '%') || str_contains($value, '-') || !is_numeric($value)) {
            return $value;
        }

        if (str_contains($value, '.') || str_contains($value, ',')) {
            $float = floatval(str_replace(',', '', $value));

            $value = intval($float);
        }

        if (!isset($units[$unitType])) {
            return number_format($value, $decimalDisplay);
        }

        $unitAbbreviation = $units[$unitType];

        // Determine the appropriate unit based on the number
        if ($unitAbbreviation == 'B') {
            return number_format($value / 1000000000);
        } elseif ($unitAbbreviation == 'M') {
            return number_format($value / 1000000);
        } elseif ($unitAbbreviation == 'T') {
            return number_format($value / 1000);
        } else {
            return number_format($value);
        }
    }

    public function parseCell($data, $key): array
    {
        $response = [];
        $response['empty'] = false;
        $response['date'] = $key;
        $response['ticker'] = $this->ticker;

        foreach ($data as $key => $value) {
            if (in_array('|', str_split($value))) {
                $array = explode('|', $value);

                $response['value'] = $array[0];
                $response['present'] = $this->generatePresent($array[0]);
                $response['hash'] = $array[1];

                if (array_key_exists(2, $array)) {
                    $response['secondHash'] = $array[2];
                }

            } else {
                $response[$key] = $value;
            }
        }

        return $response;
    }

    public function generateEmptyCellsRow(): array
    {
        $response = [];

        foreach ($this->tableDates as $date) {
            $response[$date] = [
                'date' => Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'),
                'value' => '',
                'hash' => '',
                'ticker' => $this->ticker,
                'empty' => true,
            ];
        }

        return $response;
    }

    public function updated($propertyName): void
    {
        if (
            $propertyName === 'unitType'
            || $propertyName === 'order'
            || $propertyName === 'decimalDisplay'
        ) {
            $this->regenerateTableChart();
        }

        if ($propertyName === 'view') {
            $this->getData();
        }
    }

    public function updatedPeriod()
    {
        $this->getData();
    }

    public function getNavbar()
    {
        $navbar = [];
        $acronym = ($this->period == 'annual') ? 'arf5drs' : 'qrf5drs';
        $source = 'info_presentations';
        $query = DB::connection('pgsql-xbrl')
            ->table($source)
            ->where('ticker', '=', $this->ticker)
            ->where('acronym', '=', $acronym)
            ->select('statement', 'statement_group', 'id', 'title')->get();

        $collection = $query->collect();

        foreach ($collection as $value) {
            $navbar[$value->statement_group][] = ['statement' => $value->statement, 'id' => $value->id, 'title' => $value->title];
        }
        if ($navbar === []) {
            $this->noData = true;
            return;
        }

        $this->activeIndex = 'Financial Statements [Financial Statements]';
        $this->activeSubIndex = $navbar[$this->activeIndex][0]['id'];
        $this->navbar = $navbar;
        $this->emit('navbarUpdated', $this->navbar, $this->activeIndex, $this->activeSubIndex);
    }

    public function mount(Request $request, $company, $ticker, $period)
    {
        $this->emit('periodChange', 'annual');
        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->companyName = $this->ticker;
        $companyData = @json_decode($this->company, true);
        if ($companyData && count($companyData) && is_array($companyData) && array_key_exists('name', $companyData))
            $this->companyName = $companyData['name'];
        $this->getNavbar();
        if ($this->noData === true) {
            return;
        }
        $this->getData();
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }

    }

    public function periodChange($period)
    {
        $this->period = $period;
        $this->getNavbar();
        $this->getData();
    }

    public function tabClicked($key)
    {
        $this->activeIndex = $key;
        $this->getData();
    }

    public function tabSubClicked($key)
    {
        $this->activeSubIndex = $key;
        $this->getData();
    }

    public function render()
    {
        return view('livewire.company-report');
    }
}
