<?php

namespace App\Http\Livewire\Japan;

use App\Http\Livewire\BaseProfileComponent;
use Illuminate\Database\Eloquent\Model;
use Request;

class Profile extends BaseProfileComponent
{
    public $exchange;
    public Model $model;

    public function render(){
        return view('livewire.japan-profile', [
            'exchange' => $this->exchange,
            'symbol'=> $this->model->symbol
        ]);
    }
}
