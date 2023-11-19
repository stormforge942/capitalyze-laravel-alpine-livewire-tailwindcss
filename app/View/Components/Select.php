<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $placeholder;
    public $value;

    public function __construct(
        public array $options,
        ?string $placeholder = null,
        ?string $value = null,
        ?string $name = null,
    ) {
        $this->name = $name ?? Str::random(10);
        $this->placeholder = $placeholder ?? '';
        $this->value = $value ?? '';
    }

    public function render()
    {
        return view('components.select');
    }
}
