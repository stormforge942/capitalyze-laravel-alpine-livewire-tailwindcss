<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;
use App\Services\TrackInvestorService;
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

        $this->loading = false;

        return view('livewire.track-investor.discover', [
            'funds' => $this->listStyle === 'grid' ? $this->getFunds($filters) : null,
            'filters' => $filters,
        ]);
    }

    private function getFunds(array $filters)
    {
        $cacheKey = $filters['areApplied'] ? null : 'funds_' . md5($this->search . '_perPage_' . $this->perPage);

        $cb = fn() => app(TrackInvestorService::class)
            ->fundsQuery($filters, $this->views)
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage);

        $funds = $cacheKey ? Cache::remember($cacheKey, 3600, $cb) : $cb();

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

        return $funds;
    }
}
