<?php

namespace App\Http\Livewire\TrackInvestor;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Favorites extends Component
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
        ->select('investor_name','total_value','portfolio_size','change_in_total_value')
        ->where('investor_name','=', 'Intergy Private Wealth, LLC' )
        ->orderBy('date', 'desc')
        ->get();
        $this->loading = true;
        return view('livewire.track-investor.favorites', [
            'favorites' => $data
        ]);
    }
}
