<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Fund extends Component
{
    public $loading = false;
    protected $listeners = ['loadingFire' => 'handleLoadingFire'];

    public  function handleLoadingFire(){
        $this->loading = true;
    }

    public function render()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('fs.investor_name', 'fs.total_value', 'fs.portfolio_size', 'fs.change_in_total_value', 'latest_dates.max_date')
            ->from('filings_summary as fs')
            ->join(DB::raw('(SELECT investor_name, MAX(date) AS max_date FROM filings_summary GROUP BY investor_name) as latest_dates'), function($join)
            {
                $join->on('fs.investor_name', '=', 'latest_dates.investor_name');
                $join->on('fs.date', '=', 'latest_dates.max_date');
            })
            ->get();
    
    

        $this->loading = true;
        return view('livewire.track-investor.fund', [
            'investors' => $data
        ]);
    }
}
