<?php

namespace App\Http\Livewire\CompanyReport;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InfoPresentation;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Page extends Component
{
    // filters 
    public $view;
    public $period;
    public $unitType;
    public $decimalPlaces;
    public $percentageDecimalPlaces;
    public $perShareDecimalPlaces;
    public $order;
    public $freezePane;

    public $activeTab;
    public $company;
    public $showAllRows;
    public $publicView;
    protected $rows = [];
    protected $tableDates = [];
    public $currency = 'USD';
    public $rangeDates = [];
    public $selectedDateRange;
    public $noData = false;
    public $statement = null;

    public $disclosureTabs = [];
    public $disclosureTab = '';
    public $disclosureFootnotes = [];
    public $disclosureFootnote = '';

    protected $tabs = [
        'income-statement' => 'Income Statement',
        'balance-sheet' => 'Balance Sheet',
        'cash-flow' => 'Cash Flow',
        'ratios' => 'Ratios',
        'disclosure' => 'Disclosure',
        'earning-presentation' => 'Earning Presentations'
    ];

    protected $listeners = ['periodChange', 'tabClicked', 'tabSubClicked', 'selectRow', 'unselectRow'];

    public function mount(Request $request, $company): void
    {
        $settings = validateAndSetDefaults(Auth::user()->settings ?? []);

        // set properties from query string 
        $this->activeTab = $request->query('tab', 'income-statement');
        $this->view = $request->query('view', $settings['view'] ?? 'As reported');
        $this->period = $request->query('period', $settings['period'] ?? 'Fiscal Annual');
        $this->unitType = $request->query('unitType', $settings['unit'] ?? 'Millions');
        $this->decimalPlaces = intval($request->query('decimalPlaces', $settings['decimalPlaces'] ?? '1'));
        $this->percentageDecimalPlaces = intval($request->query('percentageDecimalPlaces', $settings['percentageDecimalPlaces'] ?? '2'));
        $this->perShareDecimalPlaces = intval($request->query('perShareDecimalPlaces', $settings['perShareDecimalPlaces'] ?? '2'));
        $this->order = $request->query('order', $settings['order'] ?? 'Latest on the Right');
        $this->freezePane = $request->query('freezePane', $settings['freezePane'] ?? 'Top Row & First Column');
        $this->disclosureTab = $request->query('disclosureTab', '');
        $this->disclosureFootnote = $request->query('disclosureFootnote', '');

        $this->publicView = data_get(Auth::user(), 'settings.publicView', true);
        $this->showAllRows = session('company-report.showAllRows', false);

        $defaultYearRange = $settings['defaultYearRange'] ?? [Carbon::now()->subYears(4)->year, Carbon::now()->year];
        $range = explode(',', $request->query('selectedDateRange', ''));
        if (count($range) === 2 && is_numeric($range[0]) && is_numeric($range[1])) {
            $this->selectedDateRange = [intval($range[0]), intval($range[1])];
        } else {
            $this->selectedDateRange = $defaultYearRange;
        }

        $this->company = [
            'name' => $company['name'] ?? $company['ticker'],
            'ticker' => $company['ticker'],
        ];

        $this->setupTabData();
    }

    public function updated($prop): void
    {
        if (in_array($prop, ['view', 'activeTab', 'period', 'disclosureTab', 'disclosureFootnote'])) {
            $this->setupTabData();
        }

        if (in_array($prop, ['showAllRows'])) {
            session(['company-report.' . $prop => $this->{$prop}]);
        }
    }

    public function render()
    {
        return view('livewire.company-report.page', [
            'tabs' => $this->tabs,
            'rows' => $this->rows,
            'tableDates' => $this->tableDates,
            'colors' => config('capitalyze.chartColors'),
            'reverse' => $this->order === 'Latest on the Left',
            'viewTypes' => [
                'As reported',
                'Adjusted',
                'Standardized',
                'Per Share',
                'Common size',
            ],
            'periodTypes' => [
                'Fiscal Annual',
                'Fiscal Quarterly',
                'Fiscal Semi-Annual',
                'YTD',
                'LTM',
                'Calendar Annual',
            ],
            'unitTypes' => [
                'As Stated',
                'Thousands',
                'Millions',
                'Billions',
            ],
            'orderTypes' => [
                'Latest on the Right',
                'Latest on the Left',
            ],
            'freezePaneTypes' => [
                'Top Row',
                'First Column',
                'Top Row & First Column',
            ],
        ]);
    }

    public function setupTabData()
    {
        $this->statement = null;

        $this->noData = false;

        $data = rescue(fn () => json_decode($this->getData(), true), null, false);

        if (!$data) {
            $this->noData = true;
            return;
        }

        $this->generateTableDates($data);
        $this->generateRows($data);
    }

    public function getData(): ?string
    {
        [$acronym, $period] = in_array($this->period, ['Calendar Annual', 'Fiscal Annual'])
            ? ['arf5drs', 'annual']
            : ['qrf5drs', 'quarter'];

        if ($this->activeTab === 'disclosure') {
            return $this->disclosureData($acronym);
        }

        if ($this->view === 'Standardized') {
            return $this->standarisedData($period);
        }

        return $this->asReportedData($acronym);
    }

    private function standarisedData($period)
    {
        $column = [
            'balance-sheet' => 'balance_sheet',
            'income-statement' => 'income_statement',
            'cash-flow' => 'cash_flow',
            'ratios' => 'ratios',
        ][$this->activeTab] ?? null;

        if (!$column) {
            return null;
        }

        $cacheKey = 'infotikr_presentation_' . $this->company['ticker'] . '_' . $period . '_' . $column;

        $cacheDuration = 3600;

        $columnValue = Cache::remember($cacheKey, $cacheDuration, function () use ($period, $column) {
            return InfoTikrPresentation::query()
                ->where('ticker', $this->company['ticker'])
                ->where("period", $period)
                ->select($column)
                ->first()
                ?->{$column};
        });

        return $columnValue;
    }

    private function asReportedData($acronym)
    {
        $title = [
            'income-statement' => 'Income Statement',
            'balance-sheet' => 'Balance Sheet Statement',
            'cash-flow' => 'Cash Flow Statement',
        ][$this->activeTab] ?? null;

        if (!$title) {
            return null;
        }

        $tmp = InfoPresentation::query()
            ->where([
                'ticker' => $this->company['ticker'],
                'acronym' => $acronym,
                'title' => $title,
                'statement_group' => 'Financial Statements [Financial Statements]',
            ])
            ->select('info', 'statement')
            ->first();

        if (!$tmp) {
            return null;
        }

        $this->statement = trim(explode('[', $tmp->statement)[0]);

        return $tmp->info;
    }

    private function disclosureData($acronym)
    {
        $response = InfoPresentation::query()
            ->where([
                'ticker' => $this->company['ticker'],
                'acronym' => $acronym,
            ])
            // we already have dedicated tabs for these
            ->whereNotIn('title',  [
                'Income Statement',
                'Balance Sheet Statement',
                'Cash Flow Statement',
            ])
            // trim because title has extra space at the end
            ->get([DB::raw('TRIM(title) as title'), 'statement_group', 'statement']);

        $this->disclosureTabs = [];

        if (!$response->count()) {
            return null;
        }

        foreach ($response as $item) {
            if ($item->statement_group === 'Financial Statements [Financial Statements]') {
                $this->disclosureTabs[$item->title] = $item->title;
            } else {
                $this->disclosureFootnotes[] = $item->title;
            }
        }

        if (count($this->disclosureFootnotes)) {
            $this->disclosureTabs['footnotes'] = "Footnotes";

            if (!$this->disclosureFootnote || !in_array($this->disclosureFootnote, $this->disclosureFootnotes)) {
                $this->disclosureFootnote = $this->disclosureFootnotes[0];
            }
        }

        if (!$this->disclosureTab || !in_array($this->disclosureTab, array_keys($this->disclosureTabs))) {
            $this->disclosureTab = array_key_first($this->disclosureTabs);
        }

        $statement = $this->disclosureTab === 'footnotes'
            ? $this->disclosureFootnote
            : $this->disclosureTab;

        $tmp = InfoPresentation::query()
            ->where([
                'ticker' => $this->company['ticker'],
                'acronym' => $acronym,
            ])
            // trim because title has extra space at the end
            ->where(DB::raw('TRIM(title)'), $statement)
            ->select('info', 'statement')
            ->first();

        if (!$tmp) return null;

        $this->statement = trim(explode('[', $tmp->statement)[0]);

        return $tmp->info;
    }

    private function extractDates($array, $dates = [])
    {
        foreach ($array as $key => $value) {
            // is key date
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                if (!in_array($key, $dates)) {
                    $dates[] = $key;
                }
            } else {
                $dates = $this->extractDates($value, $dates);
            }
        }

        return $dates;
    }

    private function generateTableDates($data)
    {
        $this->tableDates = collect($this->extractDates($data))
            ->sortBy(fn ($date) => strtotime($date))
            ->values()
            ->toArray();

        $years = collect($this->tableDates)
            ->map(fn ($date) => date('Y', strtotime($date)));

        $this->rangeDates = range($years->min(), $years->max());

        $this->updateDateRangeIfNeeded();
    }

    /**
     * if there is no range i.e [null, null], create new range,
     * if there is a range, check if the start and end date are in the range,
     * if not, update the range
     */
    private function updateDateRangeIfNeeded()
    {
        $start = $this->selectedDateRange[0];
        $end = $this->selectedDateRange[1];

        if (!$start || !$end) {
            $idx = count($this->rangeDates) - 5;
            $start = $this->rangeDates[$idx < 0 ? 0 : $idx];

            $idx = count($this->rangeDates) - 1;
            $end = $this->rangeDates[$idx < 0 ? 0 : $idx];
        } else {
            if ($start < $this->rangeDates[0]) {
                $start = $this->rangeDates[0];
            }

            if ($end > $this->rangeDates[count($this->rangeDates) - 1]) {
                $end = $this->rangeDates[count($this->rangeDates) - 1];
            }
        }

        $this->selectedDateRange = [$start, $end];
    }

    private function generateRows($data)
    {
        if ($this->view !== 'Standardized') {
            if (isset($data['Income statements:']) && !isset($data['Income Statement'])) {
                $data['Income Statement'] = $data['Income statements:'];
                unset($data['Income statements:']);
            }

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
                isset($data['Statement Of Financial Position']) &&
                is_array($data['Statement Of Financial Position'])
            ) {
                $data = $data['Statement Of Financial Position'];
            }

            if (
                isset($data['Statement of Cash Flows']) &&
                is_array($data['Statement of Cash Flows'])
            ) {
                $data = $data['Statement of Cash Flows'];
            }
        }

        $rows = [];

        foreach ($data as $key => $value) {
            $rows[] = $this->generateRow($value, $key);
        }

        $this->rows = $rows;
    }

    private function generateRow($data, $title, $isSegmentation = false, $mismatchedSegmentation = false): array
    {
        $row = [
            'seg_start' => false,
            'segmentation' => false,
            'values' => $this->generateEmptyCellsRow(),
            'children' => [],
            'empty' => false,
            'mismatchedSegmentation' => $mismatchedSegmentation,
            ...$this->parseTitle($title),
            'isPercent' => false,
            'isPerShare' => false,
        ];

        $tableDates = array_reduce(
            $this->tableDates,
            function ($acc, $date) {
                $yearMonth = substr($date, 0, 7);
                $acc[$yearMonth] = $date;
                return $acc;
            },
            []
        );

        foreach ($data as $key => $value) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                if ($tableDate = $tableDates[substr($key, 0, 7)] ?? null) {
                    if (!$row['isPercent'] && $value[1] === '%') {
                        $row['isPercent'] = true;
                    }

                    if (
                        !$row['isPerShare'] && (
                            str_ends_with($value[1], '/Shares') ||
                            str_contains(strtolower($row['title']), ' per ')
                        )
                    ) {
                        $row['isPerShare'] = true;
                    }

                    $row['values'][$tableDate] = $this->parseCell($value, $key);
                }
            } else {
                if ($key === '#segmentation') {
                    foreach ($value as $sKey => $sValue) {
                        $keyn = array_keys($value[$sKey])[0];
                        $valuen = $sValue[$keyn];
                        $keynn = array_keys($valuen)[0];
                        $valuenn = $valuen[$keynn];
                        $row['children'][] = $this->generateRow($valuenn, $keynn, true, $sKey !== $this->statement);
                    }
                } else {
                    $children = $this->generateRow($value, $key, $isSegmentation);

                    if (
                        count($children['children']) ||
                        $children['title'] !== $row['title'] ||
                        collect($children['values'])->some(fn ($cell, $date) => $cell['value'] !== $row['values'][$date]['value'])
                    ) {
                        $row['children'][] = $children;
                    }
                }
            }
        }

        $row['seg_start'] = count($row['children']) && collect($row['children'])->some(fn ($child) => $child['segmentation']);
        $row['empty'] = collect($row['values'])->every(fn ($cell) => $cell['empty']);

        $row['segmentation'] = $isSegmentation && count($row['children']) === 0;

        $row['id'] = Str::uuid() . '-' . Str::uuid(); // just for the charts

        return $row;
    }

    private function parseTitle($title_)
    {
        $splitted = explode('|', $title_);

        $title = rtrim($splitted[0], ':');

        $title = ctype_upper(preg_replace('/[^a-zA-Z]/', '', $title))
            ? ucwords(strtolower($title))
            : $title;

        $parentTitle = null;

        if (str_contains($title, ':')) {
            [$title, $parentTitle] = explode(":", $title, 2);
        }

        return [
            'title' => $title,
            'parentTitle' => $parentTitle,
            'isBold' => ($splitted[1] ?? '') == 'true',
            'hasBorder' => ($splitted[2] ?? '') == 'true',
            'section' => isset($splitted[3]) ? intval($splitted[3]) : null,
        ];
    }

    private function parseCell($data, $key): array
    {
        $response = [
            'empty' => false,
            'date' => $key,
            'ticker' => $this->company['ticker'],
            'value' => null,
            'hash' => null,
            'secondHash' => null,
        ];

        $value = $data[0] ?? '';

        if (str_contains($value, '|')) {
            $array = explode('|', $value);
            $response['value'] = $array[0] ?: null;
            $response['hash'] = $array[1];
            $response['secondHash'] = $array[2] ?? null;
        }

        if (is_null($response['value']) || $response['value'] === '') {
            $response['empty'] = true;
        }

        return $response;
    }

    private function generateEmptyCellsRow(): array
    {
        $response = [];

        foreach ($this->tableDates as $date) {
            $response[$date] = [
                'date' => Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'),
                'value' => '',
                'hash' => '',
                'ticker' => $this->company['ticker'],
                'empty' => true,
            ];
        }

        return $response;
    }
}
