<?php

namespace App\Http\Livewire\Hkex;

use App\Http\Livewire\BaseProfileComponent;
use Illuminate\Database\Eloquent\Model;
use Request;

class Profile extends BaseProfileComponent
{
    public $exchange;
    public Model $model;

    public function render(){
        return view('livewire.hkex-profile', [
            'exchange' => $this->exchange,
            'symbol'=> $this->model->symbol
        ]);
    }
}
