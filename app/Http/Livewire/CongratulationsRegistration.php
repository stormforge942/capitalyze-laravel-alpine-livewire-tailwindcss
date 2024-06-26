<?php

namespace App\Http\Livewire;

use Illuminate\Auth\Notifications\VerifyEmail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CongratulationsRegistration extends Component
{
    public $user;
    public $email;
    public $isVerified;
    public $isAdminApproved;

    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            session()->flash('message', __('Your email is already verified'));
            return;
        }

        Auth::user()->notify(new VerifyEmail);

        $this->emit('verificationEmailSent');
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->email = $this->maskEmail($this->user->email);
        $this->isVerified = $this->user->hasVerifiedEmail();
        $this->isAdminApproved = $this->user->is_approved;
    }


    public function render()
    {
        return view('livewire.congratulations-registration');
    }

    private function maskEmail(string $input) {
        $symbols = 3;
        $arr = explode('@', $input);

        return substr($arr[0],0, $symbols) . str_repeat('*',strlen($arr[0]) - $symbols) . $arr[1];
    }
}
