<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyFailToDeliver extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $failToDeliver;

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getCompanyFailToDeliver();
    }

    public function getCompanyFailToDeliver() {
        $this->failToDeliver = DB::connection('pgsql-xbrl')->table('public.fail_to_deliver')->select('*')->where('symbol', $this->ticker)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.company-fail-to-deliver');
    }
}
