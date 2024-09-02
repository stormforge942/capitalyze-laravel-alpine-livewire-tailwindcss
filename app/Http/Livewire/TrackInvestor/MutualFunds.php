<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Cache;
use App\Services\TrackInvestorService;

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
            ? Cache::remember($cacheKey, 3600, fn() => $this->getFunds($filters))
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
            'filters' => $filters,
        ]);
    }

    private function getFunds($filters)
    {
        return app(TrackInvestorService::class)
            ->mutualFundsQuery($filters, $this->views)
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage);

        return $q;
    }
}
