<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

abstract class BaseProfileComponent extends Component
{
    public Model $model;
    public string $table;

    abstract public function title(): string;

    public function mount($model, string $exchange) {
        $this->table = "{$exchange}.profile-table";
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.lse-profile', [
            'title' => $this->title(),
        ]);
    }
}
