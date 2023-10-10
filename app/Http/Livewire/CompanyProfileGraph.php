<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanyProfileGraph extends Component
{
//    public $data = null;
//
//    public function mount($data)
//    {
//        $this->data = $data;
////        $this->emit('companyChartReset');
//    }
    public function render()
    {
        return view('livewire.company-profile.company-profile-graph');
    }
}
