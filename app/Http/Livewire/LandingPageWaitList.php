<?php

namespace App\Http\Livewire;

use App\Models\JoinedUser;
use App\Models\User;
use Livewire\Component;

class LandingPageWaitList extends Component
{
    public $completed = false;

    public $email = '';
    public $name = '';
    public $likedinLink = '';

    protected $rules = [
        'email' => [
            'required',
            'email',
            'unique:users,email',
            'unique:wait_list_users,email',
        ],
        'name' => 'required|min:4',
        'likedinLink' => 'nullable|url',
    ];

    public function submit()
    {
        $this->validate();

        JoinedUser::create([
            'email' => $this->email,
            'name' => $this->name,
            'likedin_link' => $this->likedinLink,
        ]);

        $this->completed = true;

    }
    public function render()
    {
        return view('livewire.landing-page-wait-list');
    }
}
