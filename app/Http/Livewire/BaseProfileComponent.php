<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

abstract class BaseProfileComponent extends Component
{
    public Model $model;

    public function mount($model, string $exchange) {
        $this->model = $model;
    }
}
