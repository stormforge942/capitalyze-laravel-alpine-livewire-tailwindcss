<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class SelectDigits extends Component
{
    public $name;
    public $placeholder;

    public function __construct(
        public array $options = [],
        ?string $placeholder = null,
        ?string $name = null,
        public bool $searchable = true,
        public bool $multiple = false,
        public string $callback = "",
        public bool $disabled = false,
        public string $size = 'sm',
        public string $color = '#D4DDD7',
    ) {
        $this->name = $name ?? Str::random(10);
        $this->placeholder = $placeholder ?? '';
    }

    public function render()
    {
        return view('components.select-digits');
    }
}
