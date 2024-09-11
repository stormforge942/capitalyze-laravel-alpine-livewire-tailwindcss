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
                foreach ($v1 as $date => $val) {
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
            ],
            'employee_count' => [
                'timeline' => [],
                'yoy_change' => [],
            ],
            'rev_by_emp' => [
                'timeline' => [],
                'yoy_change' => [],
            ],
        ];

        $findEmployeeCount = function ($date) use ($raw) {
            if (isset($raw['employee_count'][$date])) {
                return $raw['employee_count'][$date];
            }

            foreach ($raw['employee_count'] as $_date => $count) {
                $date_ = explode('-', $date);
                $_date_ = explode('-', $_date);

                // try to match the month and year
                if ($date_[0] == $_date_[0] && $date_[1] == $_date_[1]) {
                    return $count;
                }

                // try to match the year
                if ($date_[0] == $_date_[0]) {
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
        }

        $data['employee_count']['yoy_change'] = calculateYoyChange($data['employee_count']['timeline'], $this->dates);
        $data['rev_by_emp']['yoy_change'] = calculateYoyChange($data['rev_by_emp']['timeline'], $this->dates);

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
                $revenues = array_map(function ($value) {
                    return intval(explode('|', $value[0])[0]);
                }, $value);
                break;
            }
        }

        $cacheKey = 'employee_count_' . $this->company['ticker'];

        $cacheDuration = 3600;

        $employeeCount = Cache::remember($cacheKey, $cacheDuration, function () {
            return DB::connection('pgsql-xbrl')
                ->table('employee_count')
                ->where('symbol', $this->company['ticker'])
                ->pluck("count", "period_of_report")
                ->toArray();
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
}
