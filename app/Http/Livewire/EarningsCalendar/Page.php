<?php

namespace App\Http\Livewire\EarningsCalendar;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Illuminate\Support\Facades\Cache;

class Page extends Component
{
    public $exchanges;
    protected $dates = [];
    public $activeTab;
    public $customDateRange;

    protected $tabs = [
        'yesterday' => 'Yesterday',
        'today' => 'Today',
        'tomorrow' => 'Tomorrow',
        'this_week' => 'This Week',
        'next_week' => 'Next Week',
        'custom' => 'Custom',
    ];

    public function mount(Request $request)
    {
        $this->activeTab = $request->query('tab', 'today');

        $this->customDateRange = [null, null];
        if (count(explode(',', request()->query('customDateRange', ''))) === 2) {
            $this->customDateRange = explode(',', request()->query('customDateRange', ''));
        }

        $this->exchanges = DB::connection('pgsql-xbrl')
            ->table('new_earnings')
            ->select('exchange')
            ->distinct()
            ->pluck('exchange')
            ->reduce(function ($carry, $item) {
                $carry[$item] = $item;
                return $carry;
            }, []);

        $this->exchanges = [
            '' => 'All',
            ...$this->exchanges
        ];
    }

    public function getData($start = null, $end = null)
    {
        if (!$start) {
            $start = strtotime($this->dates['yesterday']) < strtotime($this->dates['this_week_start']) ? $this->dates['yesterday'] : $this->dates['this_week_start'];
        }

        if (!$end) {
            $end = $this->dates['next_week_end'];
        }

        $cacheKey = 'earnings_data_' . $start . '_' . $end;
        $cacheDuration = 3600;

        return Cache::remember($cacheKey, 3600, function () use ($start, $end) {

            $newEarnings = DB::connection('pgsql-xbrl')
            ->table('new_earnings')
            ->select('symbol', 'date', 'exchange', 'time', 'title', 'url', 'company_name', 'acceptance_time')
            ->whereBetween('date', [$start, $end])
            ->get()
            ->map(function ($item) {
                $item->origin = '8-K';
                $item->pub_time = $item->acceptance_time;
                unset($item->acceptance_time);
                return $item;
            });

            $earningsCalendar = DB::connection('pgsql-xbrl')
                ->table('earnings_calendar')
                ->select('symbol', 'date', 'exchange', 'time', 'title', 'url', 'company_name', 'pub_time')
                ->whereBetween('date', [$start, $end])
                ->get()
                ->map(function ($item) {
                    $item->origin = 'Press Release';
                    return $item;
                });

            return array_values($newEarnings
                ->merge($earningsCalendar)
                ->sortBy(function ($item) {
                    return Carbon::parse($item->date . ' ' . $item->time)->timestamp;
                })
                ->toArray());
        });
    }

    public function render()
    {
        $this->dates = [
            'yesterday' => now()->subDay()->toDateString(),
            'today' => now()->toDateString(),
            'tomorrow' => now()->addDay()->toDateString(),

            'this_week_start' => now()->startOfWeek()->toDateString(),
            'this_week_end' => now()->endOfWeek()->toDateString(),

            'next_week_start' => now()->addWeek()->startOfWeek()->toDateString(),
            'next_week_end' => now()->addWeek()->endOfWeek()->toDateString(),
        ];

        $data = $this->getData();

        $groupedData = [
            'yesterday' => [],
            'today' => [],
            'tomorrow' => [],
            'this_week' => [],
            'next_week' => [],
            'custom' => [],
        ];

        foreach ($data as $item) {
            $date = Carbon::parse($item->date);

            if ($item->date === $this->dates['yesterday']) {
                $groupedData['yesterday'][] = $item;
                continue;
            }

            if ($item->date === $this->dates['today']) {
                $groupedData['today'][] = $item;
                continue;
            }

            if ($item->date === $this->dates['tomorrow']) {
                $groupedData['tomorrow'][] = $item;
                continue;
            }

            if ($date->isBetween($this->dates['this_week_start'], $this->dates['this_week_end'])) {
                $groupedData['this_week'][] = $item;
                continue;
            }

            if ($date->isBetween($this->dates['next_week_start'], $this->dates['next_week_end'])) {
                $groupedData['next_week'][] = $item;
                continue;
            }
        }

        return view('livewire.earnings-calendar.page', [
            'dates' => $this->dates,
            'data' => $groupedData,
            'badges' => (new Js([...array_map(fn ($values) => count($values), $groupedData), 'custom' => null]))->toHtml(),
            'tabs' => $this->tabs,
        ]);
    }
}
