<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class EconomicRelease extends Component
{
    public $company;
    public $economicRelease;

    public function mount($release_id)
    {
        // only because of left bar needs a default ticker if clicked on it
        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;

        $query = DB::connection('pgsql-xbrl')
            ->table('public.data_series')
            ->where('release_id', $release_id);

        $results = $query->orderBy('last_updated', 'desc')->limit(10)->get()->toArray();

        $this->economicRelease = $results;
    }

    public function render()
    {
        return view('livewire.economic-release');
    }
}
