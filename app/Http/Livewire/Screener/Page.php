<?php

namespace App\Http\Livewire\Screener;

use Livewire\Component;
use App\Models\ScreenerTab;
use App\Models\CompanyProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Page extends Component
{
    const DATE_START = 1990;

    public const SUMMARIES = ['Max', 'Min', 'Sum', 'Median'];
    public const OPERATORS = [
        '>'=> 'Greater than (>)',
        '>=' => 'Greater than or equal (>=)',
        '<' => 'Less than (<)',
        '<=' => 'Less than or equal (<=)',
        '=' => 'Equal (=)',
        'between' => 'Between',
    ];

    public $tab = null;
    public $options = null;

    public $selectedView = 'default';

    public $universalCriteria = null;
    public $financialCriteria = null;
    public $views = null;
    public $summaries = null;

    protected $listeners = [
        'tabChanged' => 'tabChanged',
    ];

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

        // fixes the stale data issue
        if ($this->tab) {
            $this->tabChanged([
                'id' => $this->tab['id'],
                'name' => $this->tab['name'],
            ]);
        }


        return view('livewire.screener.page', [
            'dates' => [
                'annual' => $this->generateAnnualDates(),
                'quarterly' => $this->generateQuarterlyDates(),
            ],
            '_options' => [
                'summaries' => self::SUMMARIES,
                'operators' => self::OPERATORS,
            ],
        ]);
    }

    public function tabChanged($tab_)
    {
        $this->tab = $tab_;

        $tab = ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->find($tab_['id']);

        $empty = ['data' => [], 'exclude' => false];

        $universalCriteria = $tab->universal_criteria ?? [];
        $this->universalCriteria = [
            'locations' => data_get($universalCriteria, 'locations', $empty),
            'stock_exchanges' => data_get($universalCriteria, 'stock_exchanges', $empty),
            'industries' => data_get($universalCriteria, 'industries', $empty),
            'sectors' => data_get($universalCriteria, 'sectors', $empty),
            'market_cap' => data_get($universalCriteria, 'market_cap', [null, null]),
            'currencies' => data_get($universalCriteria, 'currencies', $empty),
        ];

        $this->financialCriteria = $tab->financial_criteria ?? [];

        $this->summaries = $tab->summaries;

        $this->views = $tab->views ?? [];
    }

    private function generateAnnualDates()
    {
        $dates = [];
        $currentYear = Carbon::now()->year;

        for ($i = self::DATE_START; $i <= $currentYear; $i++) {
            $dates[] = 'FY ' . $i;
        }

        return array_reverse($dates);
    }

    private function generateQuarterlyDates()
    {
        $dates = [];
        $currentYear = Carbon::now()->year;

        for ($i = self::DATE_START; $i < $currentYear; $i++) {
            $dates[] = 'Q1 ' . $i;
            $dates[] = 'Q2 ' . $i;
            $dates[] = 'Q3 ' . $i;
            $dates[] = 'Q4 ' . $i;
        }

        $currentQuarter = Carbon::now()->quarter;

        foreach (range(1, $currentQuarter) as $quarter) {
            $dates[] = 'Q' . $quarter . ' ' . $currentYear;
        }

        return array_reverse($dates);
    }
}
