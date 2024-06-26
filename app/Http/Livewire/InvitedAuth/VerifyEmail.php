<?php

namespace App\Http\Livewire\InvitedAuth;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class VerifyEmail extends Component
{
    public $email;
    public $isWrong = false;

    public function checkEmail()
    {
        $user = User::where('email', $this->email)->first();
        $this->isWrong = !$user;

        if ($user) {
            $isVerified = $user->hasVerifiedEmail();
            $isAdminApproved = $user->is_approved;
            $isPasswordSet = $user->is_password_set;

            if (!($isVerified && $isAdminApproved && $isPasswordSet)) {
                Notification::send($user, new VerifyEmailNotification);
            }

            return redirect()->route('invited-auth.confirm-email')
                ->with('user', $user->id);
        }
    }

    public function render()
    {
        return view('livewire.invited-auth.verify-email');
    }
}
