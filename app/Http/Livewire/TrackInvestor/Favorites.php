<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;

class Favorites extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public static function title(): string
    {
        return 'My Favorites';
    }

    public function render()
    {
        $investors = TrackInvestorFavorite::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where('name', 'ilike', $term);
            })
            ->get();

        $funds = $investors->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->pluck('identifier')
            ->toArray();

        $mutualFunds = $investors->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->pluck('identifier')
            ->map(fn ($item) => json_decode($item, true))
            ->filter()
            ->toArray();

        $filters = $this->formattedFilters();

        $this->loading = false;
        
        return view('livewire.track-investor.favorites', [
            'funds' => $this->getFunds($funds, $filters),
            'mutualFunds' => $this->getMutualFunds($mutualFunds, $filters),
        ]);
    }

    private function getFunds($funds, $filters)
    {
        if (empty($funds)) return collect();

        return DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('investor_name', 'cik', 'total_value', 'portfolio_size', 'change_in_total_value')
            ->where('is_latest', true)
            ->whereIn('cik', $funds)
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
            ->get()
            // sort the collection by the order of the $funds array
            ->sortBy(function ($item) use ($funds) {
                return array_search($item->cik, $funds);
            })
            ->map(function ($item) {
                $item->type = 'fund';
                $item->isFavorite = true;

                return (array) $item;
            });
    }

    private function getMutualFunds($funds, $filters)
    {
        if (empty($funds)) return collect();

        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('registrant_name', 'cik', 'fund_symbol', 'series_id', 'class_id', 'class_name', 'total_value', 'portfolio_size', 'change_in_total_value', 'date')
            ->where('is_latest', true)
            ->where(function ($q) use ($funds) {
                foreach ($funds as $fund) {
                    $q->orWhere(
                        fn ($q) => $q->where('cik', $fund['cik'])
                            ->where('series_id', $fund['series_id'])
                            ->where('class_id', $fund['class_id'])
                            ->where('class_name', $fund['class_name'])
                    );
                }

                return $q;
            })
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
            ->get()
            ->sortBy(function ($item) use ($funds) {
                return collect($funds)->search(function ($fund) use ($item) {
                    return $fund['cik'] === $item->cik
                        && $fund['series_id'] === $item->series_id
                        && $fund['class_id'] === $item->class_id
                        && $fund['class_name'] === $item->class_name;
                });
            })
            ->map(function ($item) {
                $item->id = json_encode([
                    'cik' => $item->cik,
                    'fund_symbol' => $item->fund_symbol,
                    'series_id' => $item->series_id,
                    'class_id' => $item->class_id,
                    'class_name' => $item->class_name,
                ]);

                $item->type = 'mutual-fund';
                $item->isFavorite = true;

                return (array) $item;
            });
    }
}
