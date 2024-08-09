<?php

namespace App\Http\Livewire;

use App\Models\Groups;
use App\Models\PendingInvitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class JoinAndAcceptTeamInvitation extends Component
{
    public $adminUser;

    public $role;

    public $email = '';

    public $name = '';

    public $likedinLink = '';

    public $password = '';

    public $password_confirmation = '';

    public $invitation;

    protected $rules = [
        'name' => ['required', 'min:5'],
        'likedinLink' => ['nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/in\/[\w-]+\/?$/i'],
        'password' => [
            'required',
            'min:8',
            'confirmed',
            'regex:/[A-Z]/', // At least one uppercase letter
            'regex:/[a-z]/', // At least one lowercase letter
            'regex:/[!@#$%^&*(),.?":{}|<>]/', // At least one symbol
        ],
    ];

    protected $messages = [
        'name.required' => 'Enter name',
        'name.min' => 'Please enter a minimum of 5 characters',
        'likedinLink.regex' => 'Please enter a valid linkedin profile link',
    ];

    public function mount(PendingInvitation $invitation)
    {
        $this->invitation = $invitation;
        $this->email = $invitation->email;
    }

    public function submit()
    {
        $this->validate();

        $groupId = (Groups::where('name', 'Users')->first() ?? Groups::first())->id;

        DB::transaction(function () use ($groupId) {
            $user = User::query()->forceCreate([
                'name' => $this->name,
                'email' => $this->invitation->email,
                'password' => Hash::make($this->password),
                'linkedin_link' => $this->likedinLink,
                'group_id' => $groupId,
                'is_approved' => true,
                'current_team_id' => $this->invitation->team_id,
                'email_verified_at' => now(),
            ]);

            $this->invitation->accept($user, false);
        });

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.join-and-accept-team-invitation');
    }
}
