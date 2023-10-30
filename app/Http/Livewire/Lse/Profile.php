<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseProfileComponent;
use Illuminate\Database\Eloquent\Model;
use App\Models\LseProfile;

class Profile extends BaseProfileComponent
{
    public $exchange;
    public Model $model;
    public $profile = false;

    public function viewProfile(){
        $this->profile = !$this->profile;
    }
    public function title(): string
    {
        return "LSE Profile - {$this->model->registrant_name} ({$this->model->symbol})";
    }

    public function render(){
        return view('livewire.lse-profile', [
            'data' => LseProfile::where('symbol',$this->model->symbol)->first()
        ]);
    }
}
