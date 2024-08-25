<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Cache;

class MutualFunds extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public $views = [];

    public static function title(): string
    {
        return 'N-PORT Filers';
    }

    public static function key(): string
    {
        return 'mutual-funds';
    }

    public function mount()
    {
        $entry = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select(DB::raw("min(date) as start"), DB::raw("max(date) as end"))
            ->first();

        $start = Carbon::parse($entry->start ?: now()->toDateString());
        $end = Carbon::parse($entry->end ?: now()->toDateString());

        $quarters = generate_quarter_options($start, $end);
        $this->views = [
            'most-recent' => 'Most Recent',
            'all' => 'All Historical Filers',
            ...$quarters,
        ];
    }

    public function render()
    {
        $filters = $this->formattedFilters();

        $cacheKey = $filters['areApplied'] ? null : 'mutual_funds_' . md5($this->search . '_perPage_' . $this->perPage);

        $funds = $cacheKey
            ? Cache::remember($cacheKey, 3600, fn () => $this->getFunds($filters))
            : $this->getFunds($filters);

        $favorites = TrackInvestorFavorite::where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->pluck('identifier')
            ->toArray();

        $transformedFunds = $funds->getCollection()->map(function ($fund) use ($favorites) {
            $fund = (array) $fund;

            $fund['isFavorite'] = in_array($fund['fund_symbol'], $favorites);

            return $fund;
        });

        $funds->setCollection(collect($transformedFunds));

        $this->loading = false;

        return view('livewire.track-investor.mutual-funds', [
            'funds' => $funds,
        ]);
    }

    private function getFunds($filters)
    {
        $q = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('registrant_name', 'fund_symbol', 'cik', 'series_id', 'class_id', 'class_name', 'total_value', 'portfolio_size', 'change_in_total_value', 'date');

        if ($filters['view'] === 'most-recent') {
            $quarters = array_keys($this->views);

            $q->whereIn('date', [$quarters[2] ?? 'wrong-date', $quarters[3] ?? 'wrong-date'])
                ->where('is_latest', true);
        } else if ($filters['view'] == 'all') {
            $q->where('is_latest', true);
        } else {
            $q->where('date', $filters['view']);
        }

        $q = $q->where('is_latest', true)
            ->when(
                $filters['search'],
                fn ($query) => $query->where(
                    fn ($q) => $q->where(DB::raw('registrant_name'), 'ilike', "%{$filters['search']}%")
                        ->orWhere(DB::raw('fund_symbol'), 'ilike', "%{$filters['search']}%")
                )
            )
            ->when(
                $filters['marketValue'],
                fn ($q) => $q->whereBetween('total_value', $filters['marketValue'])
            )
            ->when(
                $filters['turnover'],
                fn ($q) => $q->whereBetween('change_in_total_value', $filters['turnover'])
            )
            ->when(
                $filters['holdings'],
                fn ($q) => $q->whereBetween('portfolio_size', $filters['holdings'])
            )
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage);

        return $q;
    }
}
