<?php

namespace App\Http\Livewire\Tsx;

use App\Http\Livewire\BaseProfileComponent;
use Illuminate\Database\Eloquent\Model;
use Request;

class Profile extends BaseProfileComponent
{
    public $exchange;
    public Model $model;

    public function render(){
        return view('livewire.tsx-profile', [
            'exchange' => $this->exchange,
            'symbol'=> $this->model->symbol
        ]);
    }
}
