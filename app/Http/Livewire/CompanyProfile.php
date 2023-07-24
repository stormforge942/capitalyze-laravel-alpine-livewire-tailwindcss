<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyProfile extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $profile;

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getCompanyProfile();
    }

    public function getCompanyProfile() {
        $this->profile = DB::connection('pgsql-xbrl')->table('company_profile')->select('*')->where('symbol', $this->ticker)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.company-profile');
    }
}
