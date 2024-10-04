<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileInformation extends Component
{
    use AsTab;
    use WithFileUploads;

    public $isEdit = false;

    public $name;

    public $email;

    public $job;

    public $dob;

    public $country;

    public $linkedin_link;

    public $facebook_link;

    public $twitter_link;

    public $profilePhoto = null;

    protected $rules = [
        'name' => 'required|string|min:5|max:255',
        'email' => 'required|email|max:255',
        'job' => 'nullable|string',
        'dob' => 'nullable|date',
        'country' => 'nullable|string',
        'profilePhoto' => 'nullable|image|max:2048',
        'linkedin_link' => [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/in\/[\w-]+\/?$/i',
        ],
        'facebook_link' => [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[\w-]+\/?$/i',
        ],
        'twitter_link' => [
            'nullable',
            'url',
            'regex:/^https?:\/\/(www\.)?(twitter\.com|x\.com)\/[A-Za-z0-9_]{1,15}$/i',
        ],
    ];

    protected $messages = [
        'name.required' => 'Enter your name',
        'name.min' => 'Please enter a minimum of 5 characters',
        'email.email' => 'Please enter a valid email address',
        'linkedin_link.regex' => 'Please enter a valid LinkedIn URL',
        'facebook_link.regex' => 'Please enter a valid Facebook URL',
        'twitter_link.regex' => 'Please enter a valid Twitter URL',
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->job = $user->job;
        $this->dob = $user->dob;
        $this->country = $user->country;
        $this->linkedin_link = $user->linkedin_link;
        $this->facebook_link = $user->facebook_link;
        $this->twitter_link = $user->twitter_link;
    }

    public function updateProfile()
    {
        $this->validate();

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($this->profilePhoto) {
            $user->updateProfilePhoto($this->profilePhoto);
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'job' => $this->job,
            'dob' => $this->dob,
            'country' => $this->country,
            'linkedin_link' => $this->linkedin_link,
            'facebook_link' => $this->facebook_link,
            'twitter_link' => $this->twitter_link,
        ]);

        $this->reset('profilePhoto');
    }

    public function render()
    {
        return view('livewire.account-settings.profile-information', [
            'countries' => getCountries(),
            'user' => Auth::user(),
        ]);
    }
}
