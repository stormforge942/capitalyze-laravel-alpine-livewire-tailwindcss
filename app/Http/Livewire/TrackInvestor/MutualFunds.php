<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MutualFunds extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public static function title(): string
    {
        return 'N-PORT Filers';
    }

    public static function key(): string
    {
        return 'mutual-funds';
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

            $fund['id'] = json_encode([
                'cik' => $fund['cik'],
                'fund_symbol' => $fund['fund_symbol'],
                'series_id' => $fund['series_id'],
                'class_id' => $fund['class_id'],
                'class_name' => $fund['class_name'],
            ]);

            $fund['isFavorite'] = in_array($fund['id'], $favorites);

            return $fund;
        });

        $funds->setCollection(collect($transformedFunds));

        return view('livewire.track-investor.mutual-funds', [
            'funds' => $funds,
        ]);
    }

    private function getFunds($filters)
    {
        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('registrant_name', 'fund_symbol', 'cik', 'series_id', 'class_id', 'class_name', 'total_value', 'portfolio_size', 'change_in_total_value', 'date')
            ->where('is_latest', true)
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
    }
}
