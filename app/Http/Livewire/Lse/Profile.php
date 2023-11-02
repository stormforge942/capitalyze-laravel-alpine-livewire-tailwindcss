<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseProfileComponent;
use Illuminate\Database\Eloquent\Model;
use App\Models\LseProfile;
use Request;

class Profile extends BaseProfileComponent
{
    public $exchange;
    public Model $model;

    public function title(): string
    {
        return "LSE Profile - {$this->model->registrant_name} ({$this->model->symbol})";
    }

    public function render(){
        return view('livewire.lse-profile', [
            'exchange' => $this->exchange,
            // 'model' => $this->model,
            'symbol'=> $this->model->symbol
        ]);
    }
}
