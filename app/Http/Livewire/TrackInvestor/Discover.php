<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Discover extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public static function title(): string
    {
        return '13F Filers';
    }

    public static function key(): string
    {
        return 'discover';
    }

    public function loadMore()
    {
        $this->perPage += 20;
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

        return view('livewire.track-investor.discover', [
            'funds' => $funds,
        ]);
    }

    private function getFunds(array $filters)
    {
        return DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('investor_name', 'cik', 'total_value', 'portfolio_size', 'change_in_total_value')
            ->where('is_latest', true)
            ->when(
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
    }
}
