<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\TrackInvestorFavorite;

class Favorites extends Component
{
    use AsTab;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public static function title(): string
    {
        return 'My Favorites';
    }

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
        $investors = TrackInvestorFavorite::where('user_id', auth()->user()->id)->pluck('investor_name')->toArray();

        $data = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('fs.investor_name', 'fs.total_value', 'fs.cik', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
            ->from('filings_summary as fs')
            ->join(DB::raw('(SELECT investor_name, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name) as latest_dates'), function ($join) {
                $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
                $join->on('fs.date', '=', 'latest_dates.max_date');
            })
            ->whereIn('fs.investor_name', $investors)
            ->when($this->search, function ($q) {
                return $q->where(DB::raw('fs.investor_name'), 'ilike', "%$this->search%")
                    ->orWhere(DB::raw('fs.cik'), 'like', "%$this->search%");
            })
            ->orderBy('total_value', 'desc')
            ->paginate($this->perPage)
            ->through(function ($item) {
                $item->isFavorite = true;
                return (array) $item;
            });

        return view('livewire.track-investor.favorites', [
            'funds' => $data
        ]);
    }
}
