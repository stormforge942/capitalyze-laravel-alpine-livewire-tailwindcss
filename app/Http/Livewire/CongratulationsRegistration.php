<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CongratulationsRegistration extends Component
{
    public $user;
    public $isVerified;
    public $isAdminApproved;

    public function mount()
    {
        $this->user = Auth::user();
        $this->isVerified = $this->user->hasVerifiedEmail();
        $this->isAdminApproved = $this->user->is_approved;
    }


    public function render()
    {
        return view('livewire.congratulations-registration');
    }
}