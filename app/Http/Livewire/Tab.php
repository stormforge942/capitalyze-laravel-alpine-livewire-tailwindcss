<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

abstract class Tab extends Component
{
    protected array $data = [];

    public static function title(): string
    {
        return Str::title(Str::snake(class_basename(get_called_class()), ' '));
    }

    public static function key(): string
    {
        return Str::kebab(class_basename(get_called_class()));
    }

    public function mount(array $data = [])
    {
        $this->data = $data;
    }
}
