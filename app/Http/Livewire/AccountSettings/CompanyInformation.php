<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompanyInformation extends Component
{
    use AsTab;

    public $info;

    public $companyName;

    public $companyEmail;

    public $companyIndustry;

    public $headquarters;

    public $employees;

    public $companySize;

    public $cik;

    public $companyWebsite;

    public $companyLinkedin;

    public $companyFacebook;

    public $companyTwitter;

    public $isEdit = false;

    protected $rules = [
        'companyName' => 'required|string|min:5|max:255',
        'companyEmail' => 'nullable|email|max:255',
        'companyIndustry' => 'nullable|string',
        'headquarters' => 'nullable|string',
        'employees' => 'nullable|integer|min:1',
        'cik' => 'nullable|string',
        'companyWebsite' => 'nullable|url',
        'companyLinkedin' => [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/in\/[\w-]+\/?$/i',
        ],
        'companyFacebook' => [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[\w-]+\/?$/i',
        ],
        'companyTwitter' => [
            'nullable',
            'url',
            'regex:/^https?:\/\/(www\.)?(twitter\.com|x\.com)\/[A-Za-z0-9_]{1,15}$/i',
        ],
    ];

    protected $messages = [
        'companyName.required' => 'Enter company name',
        'companyName.min' => 'Please enter a minimum of 5 characters',
        'companyEmail.email' => 'Please enter a valid email address',
        'companyIndustry.string' => 'Please enter a valid industry',
        'cik.string' => 'Please enter a valid CIK',
        'companyWebsite.url' => 'Please enter a valid website URL',
        'companyLinkedin.regex' => 'Please enter a valid linkedin profile link',
        'companyFacebook.regex' => 'Please enter a valid facebook profile link',
        'companyTwitter.regex' => 'Please enter a valid twitter profile link',
    ];

    public function mount()
    {
        $this->info = Auth::user()->team;
        $this->updateProps();
    }

    public function updateInformation()
    {
        $this->validate();

        $this->info->update([
            'name' => $this->companyName,
            'email' => $this->companyEmail,
            'industry' => $this->companyIndustry,
            'country' => $this->headquarters,
            'employees' => $this->employees,
            'cik' => $this->cik,
            'website' => $this->companyWebsite,
            'linkedin_link' => $this->companyLinkedin,
            'twitter_link' => $this->companyTwitter,
            'facebook_link' => $this->companyFacebook,
        ]);

        $this->updateProps();
        $this->isEdit = false;
    }

    public function updateProps()
    {
        $this->companyName = $this->info->name;
        $this->companyEmail = $this->info->email;
        $this->companyIndustry = $this->info->industry;
        $this->headquarters = $this->info->country;
        $this->employees = $this->info->employees;
        $this->companySize = $this->info->companySize;
        $this->cik = $this->info->cik;
        $this->companyWebsite = $this->info->website;
        $this->companyLinkedin = $this->info->linkedin_link;
        $this->companyFacebook = $this->info->facebook_link;
        $this->companyTwitter = $this->info->twitter_link;
    }

    public function render()
    {
        return view('livewire.account-settings.company-information', [
            'countries' => getCountries(),
        ]);
    }
}
