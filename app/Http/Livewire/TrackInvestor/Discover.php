<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;

class Discover extends Component
{
    use AsTab;

    protected $listeners = [
        'update' => '$refresh',
        'search:discover' => 'updatedSearch',
    ];

    public $perPage = 20;
    public $search = "";

    public static function title(): string
    {
        return 'Funds';
    }

    public static function key(): string
    {
        return 'discover';
    }

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
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->pluck('identifier')
            ->toArray();

        $funds = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('fs.investor_name', 'fs.cik', 'fs.total_value', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
            ->from('filings_summary as fs')
            ->join(DB::raw('(SELECT investor_name, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name) as latest_dates'), function ($join) {
                $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
                $join->on('fs.date', '=', 'latest_dates.max_date');
            })
            ->when($this->search, function ($q) {
                return $q->where(DB::raw('fs.investor_name'), 'ilike', "%$this->search%")
                    ->orWhere(DB::raw('fs.cik'), $this->search);
            })
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage)
            ->through(function ($item) use ($favorites) {
                $item->id = json_encode([
                    'investor_name' => $item->investor_name,
                    'cik' => $item->cik,
                ]);

                $item->isFavorite = in_array($item->id, $favorites);
                return (array) $item;
            });

        return view('livewire.track-investor.discover', [
            'funds' => $funds,
        ]);
    }
}
