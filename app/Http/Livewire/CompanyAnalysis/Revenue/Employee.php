<?php

namespace App\Http\Livewire\CompanyAnalysis\Revenue;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\InfoTikrPresentation;
use App\Http\Livewire\CompanyAnalysis\HasFilters;
use Illuminate\Support\Facades\Cache;

class Employee extends Component
{
    use HasFilters;

    public $company;
    public $rawData = [];
    public $publicView;
    public $hashes = [];
    public $chartConfig = [
        'showLabel' => false,
    ];

    public function mount()
    {
        $data = $this->getData();
        $this->extractDates($data);
        $this->formatData($data);

        $this->publicView = data_get(Auth::user(), 'settings.publicView', true);
    }

    public function updated($prop)
    {
        if (in_array($prop, ['period'])) {
            $data = $this->getData();
            $this->extractDates($data);
            $this->formatData($data);
        }
    }

    public function render()
    {
        return view('livewire.company-analysis.revenue.employee', [
            'data' => $this->makeData(),
            'hashes' => $this->hashes,
            'chart' => [
                'data' => $this->makeChartData(),
                'key' => $this->makeChartKey(),
            ]
        ]);
    }

    private function makeData()
    {
        $this->updateSelectedDates();

        $data = $this->rawData;

        foreach ($data as $k0 => $v0) {
            foreach ($v0 as $k1 => $v1) {
                if (in_array($k1, ['formulas', 'links'])) {
                    continue;
                }

                foreach ($v1 as $date => $val) {
                    if ($k0 === 'employee_count' && $k1 === 'timeline') {
                        $data[$k0][$k1][$date] = [
                            'formatted' => custom_number_format($val, 0),
                            'value' => $val,
                        ];

                        continue;
                    }

                    if ($k1 === 'timeline') {
                        $formatted = !$val ? 'N/A' : $this->formatValue($val);
                    } else {
                        $formatted = $this->formatPercentageValue($val);
                    }

                    $data[$k0][$k1][$date] = [
                        'formatted' => $formatted,
                        'value' => $val,
                    ];
                }
            }
        }

        return $data;
    }

    private function makeChartData()
    {
        $data = $this->rawData;

        return [
            [
                'label' => '% Change YoY',
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'y' => round($data['rev_by_emp']['yoy_change'][$date], $this->decimalPlaces),
                ], $this->selectedDates),
                "fill" => false,
                "yAxisID" => 'y1',
                "backgroundColor" => '#C22929',
                "borderColor" => '#C22929',
                'type' => 'line',
                'pointRadius' => 0,
                'dataType' => 'percentage',
            ],
            [
                'label' => 'Revenue / Employee',
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'y' => $data['rev_by_emp']['timeline'][$date],
                ], $this->selectedDates),
                "borderRadius" => 2,
                "fill" => true,
                "backgroundColor" => $this->chartColors[2],
            ],
        ];
    }

    private function formatData($raw)
    {
        $data = [
            'revenues' => [
                'timeline' => $raw['revenues'],
                'yoy_change' => calculateYoyChange($raw['revenues'], $this->dates),
                'formulas' => $this->makeFormulasDescription($raw['revenues'], $this->dates, 'Total Revenues'),
            ],
            'employee_count' => [
                'timeline' => [],
                'yoy_change' => [],
                'formulas' => [],
                'links' => $this->extractLinks($raw),
            ],
            'rev_by_emp' => [
                'timeline' => [],
                'yoy_change' => [],
                'formulas' => [],
            ],
        ];

        $findEmployeeCount = function ($date) use ($raw) {
            if (isset($raw['employee_count'][$date]['count'])) {
                return $raw['employee_count'][$date]['count'];
            }

            foreach ($raw['employee_count'] as $_date => $count) {
                $date_ = explode('-', $date);
                $_date_ = explode('-', $_date);

                // try to match the month and year
                if ($date_[0] == $_date_[0] && $date_[1] == $_date_[1]) {
                    if (is_array($count)) return $count['count'];
                    return $count;
                }

                // try to match the year
                if ($date_[0] == $_date_[0]) {
                    if (is_array($count)) return $count['count'];
                    return $count;
                }
            }

            return 0;
        };

        foreach ($this->dates as $date) {
            $revenue = $data['revenues']['timeline'][$date];
            $empCount = $findEmployeeCount($date);

            $data['employee_count']['timeline'][$date] = $empCount;

            $data['rev_by_emp']['timeline'][$date] = $empCount ? $revenue / $empCount : 0;
            $data['rev_by_emp']['formulas']['rev_by_emp'][$date] = makeFormulaDescription([$revenue, $empCount], $data['rev_by_emp']['timeline'][$date], $date, '', 'rev_by_emp');
        }

        $data['employee_count']['yoy_change'] = calculateYoyChange($data['employee_count']['timeline'], $this->dates);
        $data['employee_count']['formulas']['yoy_change'] = $this->makeFormulasDescription($data['employee_count']['timeline'], $this->dates, 'Employee Count');

        $data['rev_by_emp']['yoy_change'] = calculateYoyChange($data['rev_by_emp']['timeline'], $this->dates);
        $data['rev_by_emp']['formulas']['yoy_change'] = $this->makeFormulasDescription($data['rev_by_emp']['timeline'], $this->dates, "Revenue / Employee ('000s)");

        $this->rawData = $data;
    }

    private function getData()
    {
        $period = ($this->period == 'quarterly') ? 'quarter' : 'annual';

        $cacheKey = 'info_tikr_presentation_' . $this->company['ticker'] . '_' . $period . '_income_statement';

        $cacheDuration = 3600;

        $stmt = Cache::remember($cacheKey, $cacheDuration, function () use ($period) {
            return rescue(fn () => json_decode(
                InfoTikrPresentation::where('ticker', $this->company['ticker'])
                    ->where('period', $period)
                    ->orderByDesc('id')
                    ->select(['income_statement'])
                    ->first()
                    ?->income_statement ?? "{}",
                true
            ), [], false);
        });

        $revenues = [];

        foreach ($stmt as $key => $value) {
            if (str_starts_with($key, 'Revenues|')) {
                $this->hashes = array_map(function ($value) {
                    $hashExtractionResult = $this->extractHashes($value);

                    return [
                        'hash' => $hashExtractionResult['hash'],
                        'secondHash' => $hashExtractionResult['secondHash']
                    ];
                }, $value);

                $revenues = array_map(function ($value) {
                    return intval(explode('|', $value[0])[0]);
                }, $value);
                break;
            }
        }

        $cacheKey = 'employee_count_' . $this->company['ticker'];

        $cacheDuration = 3600;

        $employeeCount = Cache::remember($cacheKey, $cacheDuration, function () {
            $result = DB::connection('pgsql-xbrl')
                ->table('employee_count')
                ->where('symbol', $this->company['ticker'])
                ->select('s3_url', 'count', 'period_of_report')
                ->get();

            return $result->reduce(function ($carry, $item) {
                $carry[$item->period_of_report] = ['count' => $item->count, 'url' => $item->s3_url];
                return $carry;
            }, []);
        });

        return [
            'revenues' => $revenues,
            'employee_count' => $employeeCount
        ];
    }

    private function extractDates($data)
    {
        if (!count($data['revenues'])) {
            $this->dates = [];
            return;
        }

        $dates = array_keys($data['revenues']);

        $this->selectDates($dates);
    }

    private function extractHashes($data)
    {
        list($value, $hash, $secondHash) = array_pad(explode('|', $data[0]), 3, null);

        return [
            'value' => $value,
            'hash' => $hash,
            'secondHash' => $secondHash,
        ];
    }

    private function extractLinks($data)
    {
        $result = [];

        if (!isset($data['employee_count'])) {
            return $result;
        }

        return array_map(function ($item) { return $item['url'];  }, $data['employee_count']);
    }

    private function makeFormulasDescription($values, $dates, $metric)
    {
        $result = [];

        $calculationResult = calculateYoyChange($values, $dates);

        foreach ($calculationResult as $date => $value) {
            if ($value) {
                $firstValueDateIndex = array_search($date, $dates);
                $secondValueDateIndex = $firstValueDateIndex - 1;

                $result[$date] = makeFormulaDescription([$values[$dates[$firstValueDateIndex]], $values[$dates[$secondValueDateIndex]]], $value, $date, $metric, 'yoy_change');
            }
        }

        return $result;
    }
}
