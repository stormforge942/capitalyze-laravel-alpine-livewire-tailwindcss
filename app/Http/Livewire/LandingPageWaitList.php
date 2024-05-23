<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class LandingPageWaitList extends Component
{
    public $completed = false;
    public $alreadyOnWaitlist = false;

    public $email = '';
    public $name = '';
    public $likedinLink = '';

    protected $rules = [
        'email' => [
            'required',
            'email:rfc,dns',
            // 'unique:users,email',
        ],
        'name' => ['required', 'min:5'],
        'likedinLink' => ['nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/in\/[\w-]+\/?$/i'],
    ];

    protected $messages = [
        'email.required' => 'Enter valid email address',
        'name.required' => 'Enter name',
        'email.email' => 'Please enter a valid email address',
        // 'email.unique' => 'This email is already registered. Please continue to login',
        'name.min' => 'Please enter a minimum of 5 characters',
        'likedinLink.regex' => 'Please enter a valid linkedin profile link',
    ];

    public function submit()
    {
        $this->validate();

        if (User::query()->where('email', $this->email)->exists()) {
            $this->alreadyOnWaitlist = true;
            return;
        }

        $user = app(CreateNewUser::class)->createUser([
            'email' => $this->email,
            'name' => $this->name,
            'linkedin_link' => $this->likedinLink,
            'password' => Str::random(25),
        ]);

        event(new Registered($user));

        $this->completed = true;
    }

    public function render()
    {
        return view('livewire.landing-page-wait-list', [
            'verified' => request('verified') === "1",
        ]);
    }
}
