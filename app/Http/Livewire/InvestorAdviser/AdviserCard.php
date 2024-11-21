<?php

namespace App\Http\Livewire\InvestorAdviser;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdviserCard extends Component
{
    public $adviser;
    public $assets_under_management;
    public $crd_number;
    public $sec_region;
    public $sec_number;
    public $cik;

    public function mount($adviser)
    {
        $this->adviser = $adviser;
        $form_data = (array) json_decode($adviser['form_data']);
        $this->assets_under_management = $adviser['assets_under_management'];
        $this->crd_number = $form_data['Organization CRD#'];
        $this->sec_region = $form_data['SEC Region'];
        $this->sec_number = $form_data['SEC#'];
        $this->cik = $adviser['cik'] ?? '-';
    }

    public function render()
    {
        return view('livewire.investor-adviser.adviser-card');
    }
}
