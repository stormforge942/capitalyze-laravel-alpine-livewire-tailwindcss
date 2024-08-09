<?php

namespace App\Http\Livewire;

use App\Models\PendingInvitation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AcceptTeamInvitation extends Component
{
    public ?PendingInvitation $invitation = null;

    public function mount(PendingInvitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function boot()
    {
        $this->invitation?->refresh();
    }

    public function submit()
    {
        if (! Auth::user() || Auth::user()->email !== $this->invitation->email) {
            Auth::logout();

            return redirect()->route('login');
        }

        $user = Auth::user();

        abort_if($this->invitation->email != $user->email, 403);

        $this->invitation->accept($user);
    }

    public function render()
    {
        return view('livewire.accept-team-invitation', [
            'canAccept' => Auth::user() && Auth::user()->email === $this->invitation->email,
        ]);
    }
}
