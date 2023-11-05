<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;

class Fund extends Component
{
    public $loading = false;
    public $perPage = 20;
    public $addFavorites = [];
    public $search = "";
    protected $listeners = ['loadingFire' => 'handleLoadingFire', 'seachFilterValue'];

    public function loadMore(){
        $this->perPage += 20;
        $this->loading = false;
    }

    public function seachFilterValue($val){
        $this->search = $val;
    }

    public  function handleLoadingFire(){
        $this->loading = true;
    }

    public function handleFavorite($name){
        $this->loading = true;
        $data = TrackInvestorFavorite::create([
            'investor_name' => $name,
            'user_id' => auth()->user()->id
        ]);
        $this->loading = false;
        $this->addFavorite = true;
        $this->addFavorites[] = $name;
    }

    public function render()
    {
        //$investors = TrackInvestorFavorite::where('user_id', auth()->user()->id)->pluck('investor_name')->toArray();
        $data = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->select('fs.investor_name', 'fs.total_value', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
        ->from('filings_summary as fs')
        ->join(DB::raw('(SELECT investor_name, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name) as latest_dates'), function($join)
        {
            $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
            $join->on('fs.date', '=', 'latest_dates.max_date');
        });
        if($this->search) {
            $data = $data->where('fs.investor_name','like', "%$this->search%")
            ->orWhere('fs.total_value','like', "%$this->search%")
            ->orWhere('fs.portfolio_size', 'like', "%$this->search%")
            ->orWhere('fs.change_in_total_value', 'like', "%$this->search%")
            ->orWhere('fs.date','like', "%$this->search%");
        }
        $data = $data
        //->whereNotIn('fs.investor_name', $investors)
        ->orderBy('total_value', 'desc')
        ->paginate($this->perPage);
        $this->loading = false;
        return view('livewire.track-investor.fund', [
            'investors' => $data
        ]);
    }
}
