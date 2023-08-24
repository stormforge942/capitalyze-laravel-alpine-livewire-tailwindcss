<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class PressRelease extends Component
{
    public $company;
    public $pressReleases;

    public function mount()
    {
        // only because of left bar needs a default ticker if clicked on it
        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;

        $query = DB::connection('pgsql-xbrl')
            ->table('public.press_releases')->orderBy('date', 'desc')->limit(100)->get()->toArray();

        $this->pressReleases = $query;
    }

    public function render()
    {
        return view('livewire.press-release');
    }
}
