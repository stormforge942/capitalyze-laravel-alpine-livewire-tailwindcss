<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;

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
        ],
        'name' => 'required|min:4',
        'likedinLink' => 'nullable|url',
    ];

    public function submit()
    {
        $this->validate();

        $user = app(CreateNewUser::class)->createUser([
            'email' => $this->email,
            'name' => $this->name,
            'likedin_link' => $this->likedinLink,
            'password' => Str::random(25),
        ]);

        event(new Registered($user));
        
        $this->completed = true;
    }

    public function render()
    {
        return view('livewire.landing-page-wait-list');
    }
}
