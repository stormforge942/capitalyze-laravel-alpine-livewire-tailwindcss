<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class EconomicReleaseSeries extends Component
{
    public $company;
    public $series_id;

    public function mount($release_id, $series_id)
    {
        // only because of left bar needs a default ticker if clicked on it
        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;

        $this->series_id = $series_id;
    }

    public function getLineChart() {
        $query = DB::connection('pgsql-xbrl')
            ->table('public.data_observations')
            ->where('series_id', $this->series_id)
            ->orderBy('series_id', 'asc')
            ->orderBy('date', 'asc');

        $results = $query->get()->toArray();

        $this->emit('getLineChart', $results);

        return $results;
    }

    public function render()
    {
        return view('livewire.economic-release-series');
    }
}
