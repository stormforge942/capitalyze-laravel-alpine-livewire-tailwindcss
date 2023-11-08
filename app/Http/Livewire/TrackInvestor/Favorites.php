<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\TrackInvestorFavorite;

class Favorites extends Component
{
    use AsTab;

    protected $listeners = ['update' => '$refresh'];

    public static function title(): string
    {
        return 'My Favorites';
    }

    public $loading = false;
    public $perPage = 20;
    public $search = "";
    public $removeFavorites = [];
    public $removeFavorite = false;

    public function loadMore()
    {
        $this->perPage += 20;
    }
    public function seachFilterValue($val)
    {
        $this->search = $val;
    }

    public function removeFavorite($investor)
    {
        $this->loading = true;
        TrackInvestorFavorite::where('investor_name', $investor)->where('user_id', auth()->user()->id)
            ->delete();
        $this->removeFavorites[] = $investor;
        $this->removeFavorite = true;
        $this->loading = false;
    }

    public  function handleLoadingFire()
    {
        $this->loading = true;
    }

    public function render()
    {
        $this->loading = true;
        $investors = TrackInvestorFavorite::where('user_id', auth()->user()->id)->pluck('investor_name')->toArray();
        $data = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('fs.investor_name', 'fs.total_value', 'fs.cik', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
            ->from('filings_summary as fs')
            ->join(DB::raw('(SELECT investor_name, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name) as latest_dates'), function ($join) {
                $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
                $join->on('fs.date', '=', 'latest_dates.max_date');
            })
            ->whereIn('fs.investor_name', $investors);
        if ($this->search) {
            $data = $data->where(DB::raw('fs.investor_name'), 'like', "%$this->search%");
            // ->orWhere(DB::raw('fs.total_value'),'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.portfolio_size'), 'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.change_in_total_value'), 'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.cik'), 'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.date'),'like', "%$this->search%");
        }
        $data = $data
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage);
        $this->loading = false;
        return view('livewire.track-investor.favorites', [
            'favorites' => $data
        ]);
    }
}
