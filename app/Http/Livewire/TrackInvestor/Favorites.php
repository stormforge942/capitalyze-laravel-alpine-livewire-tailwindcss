<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;

class Favorites extends Component
{
    use AsTab;

    protected $listeners = [
        'update' => '$refresh',
        'search:favorites' => 'updatedSearch',
    ];

    public static function title(): string
    {
        return 'My Favorites';
    }

    public $search = "";

    public function updatedSearch($search)
    {
        $this->search = $search;
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
            ->map(fn ($item) => json_decode($item, true))
            ->filter()
            ->toArray();

        $mutualFunds = $investors->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->pluck('identifier')
            ->map(fn ($item) => json_decode($item, true))
            ->filter()
            ->toArray();

        return view('livewire.track-investor.favorites', [
            'funds' => $this->getFunds($funds),
            'mutualFunds' => $this->getMutualFunds($mutualFunds),
        ]);
    }

    private function getFunds($funds)
    {
        if (empty($funds)) return collect();

        return DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('fs.investor_name', 'fs.total_value', 'fs.cik', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
            ->from('filings_summary as fs')
            ->join(DB::raw('(SELECT investor_name, cik, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name, cik) as latest_dates'), function ($join) {
                $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
                $join->on('fs.cik', '=', 'latest_dates.cik');
                $join->on('fs.date', '=', 'latest_dates.max_date');
            })
            ->where(function ($q) use ($funds) {
                foreach ($funds as $fund) {
                    $q->orWhere(fn ($q) => $q->where('fs.investor_name', $fund['investor_name'])
                        ->where('fs.cik', $fund['cik']));
                }

                return $q;
            })
            ->get()
            ->map(function ($item) {
                $item->id = json_encode([
                    'investor_name' => $item->investor_name,
                    'cik' => $item->cik,
                ]);

                $item->type = 'fund';
                $item->isFavorite = true;

                return (array) $item;
            });
    }

    private function getMutualFunds($funds)
    {
        if (empty($funds)) return collect();

        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('hs.registrant_name', 'hs.cik', 'hs.fund_symbol', 'hs.series_id', 'hs.class_id', 'hs.class_name', 'hs.total_value', 'hs.portfolio_size', 'hs.change_in_total_value', 'hs.date')
            ->from('mutual_fund_holdings_summary as hs')
            ->join(DB::raw('(SELECT registrant_name, cik, fund_symbol, series_id, class_id, class_name, MAX(date) AS max_date FROM mutual_fund_holdings_summary GROUP BY registrant_name, cik, fund_symbol, series_id, class_id, class_name) as latest_dates'), function ($join) {
                $join->on('hs.registrant_name', '=', 'latest_dates.registrant_name');
                $join->on('hs.cik', '=', 'latest_dates.cik');
                $join->on('hs.fund_symbol', '=', 'latest_dates.fund_symbol');
                $join->on('hs.series_id', '=', 'latest_dates.series_id');
                $join->on('hs.class_id', '=', 'latest_dates.class_id');
                $join->on('hs.class_name', '=', 'latest_dates.class_name');
                $join->on('hs.date', '=', 'latest_dates.max_date');
            })
            ->where(function ($q) use ($funds) {
                foreach ($funds as $fund) {
                    $q->orWhere(
                        fn ($q) => $q->where('hs.cik', $fund['cik'])
                            ->where('hs.series_id', $fund['series_id'])
                            ->where('hs.class_id', $fund['class_id'])
                            ->where('hs.class_name', $fund['class_name'])
                    );
                }

                return $q;
            })
            ->get()
            ->map(function ($item) {
                $item->id = json_encode([
                    'registrant_name' => $item->registrant_name,
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
