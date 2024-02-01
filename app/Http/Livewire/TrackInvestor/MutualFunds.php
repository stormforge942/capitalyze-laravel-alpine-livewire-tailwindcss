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
            ->select('registrant_name', 'cik', 'fund_symbol', 'series_id', 'class_id', 'class_name', 'total_value', 'portfolio_size', 'change_in_total_value', 'date')
            ->from('mutual_fund_holdings_summary as hs')
            ->where('is_latest', true)
            ->when($this->search, function ($q) {
                return $q->where(DB::raw('registrant_name'), 'ilike', "%$this->search%")
                    ->orWhere(DB::raw('fund_symbol'), strtoupper($this->search));
            })
            ->orderBy('total_value', 'desc')
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
