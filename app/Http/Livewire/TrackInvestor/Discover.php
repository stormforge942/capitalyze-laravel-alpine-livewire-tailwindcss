<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Cache;

class Discover extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public $views = [];

    public static function title(): string
    {
        return '13F Filers';
    }

    public static function key(): string
    {
        return 'discover';
    }

    public function mount()
    {
        $entry = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
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

        $cacheKey = $filters['areApplied'] ? null : 'funds_' . md5($this->search . '_perPage_' . $this->perPage);

        $funds = $cacheKey
            ? Cache::remember($cacheKey, 3600, fn () => $this->getFunds($filters))
            : $this->getFunds($filters);

        $favorites = TrackInvestorFavorite::where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->pluck('identifier')
            ->toArray();

        $transformedFunds = $funds->getCollection()->map(function ($fund) use ($favorites) {
            $fundArray = (array)$fund;
            $fundArray['isFavorite'] = in_array($fundArray['cik'], $favorites);
            return $fundArray;
        });

        $funds->setCollection(collect($transformedFunds));

        $this->loading = false;

        return view('livewire.track-investor.discover', [
            'funds' => $funds,
        ]);
    }

    private function getFunds(array $filters)
    {
        $q = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('investor_name', 'cik', 'total_value', 'portfolio_size', 'change_in_total_value');

        if ($filters['view'] === 'most-recent') {
            $quarters = array_keys($this->views);

            $q->whereIn('date', [$quarters[2], $quarters[3]]);
        } else if ($filters['view'] == 'all') {
            $q->where('is_latest', true);
        } else {
            $q->where('date', $filters['view']);
        }

        $q = $q->when(
            $filters['search'],
            fn ($query) => $query->where(
                fn ($q) => $q->where(DB::raw('investor_name'), 'ilike', "%{$filters['search']}%")
                    ->orWhere(DB::raw('cik'), $filters['search'])
            )
        )
            ->when($filters['marketValue'], function ($query) use ($filters) {
                return $query->whereBetween('total_value', $filters['marketValue']);
            })
            ->when($filters['turnover'], function ($query) use ($filters) {
                return $query->whereBetween('change_in_total_value', $filters['turnover']);
            })
            ->when($filters['holdings'], function ($query) use ($filters) {
                return $query->whereBetween('portfolio_size', $filters['holdings']);
            })
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage);

        return $q;
    }
}
