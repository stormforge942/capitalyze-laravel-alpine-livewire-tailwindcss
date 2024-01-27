<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;

class MutualFunds extends Component
{
    use AsTab;

    protected $listeners = [
        'update' => '$refresh',
        'search:mutual-funds' => 'updatedSearch',
    ];

    public $perPage = 20;
    public $search = "";

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->reset('perPage');
    }

    public function render()
    {
        $favorites = TrackInvestorFavorite::query()
            ->where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->pluck('identifier')
            ->toArray();

        // to get the values of max date we need join the table with itself
        $funds = DB::connection('pgsql-xbrl')
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
            ->when($this->search, function ($q) {
                return $q->where(DB::raw('hs.registrant_name'), 'ilike', "%$this->search%")
                    ->orWhere(DB::raw('hs.fund_symbol'), strtoupper($this->search));
            })
            // ->orderBy('total_value', 'desc')
            ->paginate($this->perPage)
            ->through(function ($item) use ($favorites) {
                $item->id = json_encode([
                    'registrant_name' => $item->registrant_name,
                    'cik' => $item->cik,
                    'fund_symbol' => $item->fund_symbol,
                    'series_id' => $item->series_id,
                    'class_id' => $item->class_id,
                    'class_name' => $item->class_name,
                ]);

                $item->isFavorite = in_array($item->id, $favorites);

                return (array) $item;
            });

        return view('livewire.track-investor.mutual-funds', [
            'funds' => $funds,
        ]);
    }
}
