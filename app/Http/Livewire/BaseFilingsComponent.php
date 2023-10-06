<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

abstract class BaseFilingsComponent extends Component
{
    public Model $model;

    abstract public function title(): string;
    abstract public function table(): string;

    public function mount($model) {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.base-filings', [
            'title' => $this->title(),
            'table' => $this->table(),
        ]);
    }
}
