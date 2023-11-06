<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;

class Fund extends Component
{
    public $loading = false;
    public $perPage = 20;
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
        $isExist = TrackInvestorFavorite::where('investor_name', $name)
        ->where('user_id', auth()->user()->id)
        ->first();
        if(empty($isExist)){
            $data = TrackInvestorFavorite::create([
                'investor_name' => $name,
                'user_id' => auth()->user()->id
            ]);
            $this->loading = false;
        }
        
    }

    public function render()
    {
        $favorites = TrackInvestorFavorite::where('user_id', auth()->user()->id)->pluck('investor_name')->toArray();
        $data = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->select('fs.investor_name','fs.cik', 'fs.total_value', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
        ->from('filings_summary as fs')
        ->join(DB::raw('(SELECT investor_name, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name) as latest_dates'), function($join)
        {
            $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
            $join->on('fs.date', '=', 'latest_dates.max_date');
        });
        if($this->search) {
            $data = $data->where(DB::raw('fs.investor_name'),'ilike', "%$this->search%");
            // ->orWhere(DB::raw('fs.total_value'),'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.portfolio_size'), 'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.change_in_total_value'), 'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.cik'), 'like', "%$this->search%")
            // ->orWhere(DB::raw('fs.date'),'like', "%$this->search%");
        }
        $data = $data
        //->whereNotIn('fs.investor_name', $favorites)
        ->orderBy('total_value', 'desc')
        ->paginate($this->perPage);
        $this->loading = false;
        return view('livewire.track-investor.fund', [
            'investors' => $data,
            'favorites' => $favorites
        ]);
    }
}
