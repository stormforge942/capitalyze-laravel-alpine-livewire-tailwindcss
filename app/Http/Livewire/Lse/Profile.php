<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseProfileComponent;

class Profile extends BaseProfileComponent
{

    public function table(): string
    {
        return 'company_profile_intl';
    }
    public function title(): string
    {
        return "LSE Profile - {$this->model->registrant_name} ({$this->model->symbol})";
    }
}
