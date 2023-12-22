<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $placeholder;

    public function __construct(
        public array $options,
        ?string $placeholder = null,
        ?string $name = null,
        public bool $searchable = false,
    ) {
        if (!$this->associativeArray($options)) {
            $this->options = array_reduce($options, function ($carry, $item) {
                $carry[$item] = $item;
                return $carry;
            }, []);
        }

        $this->name = $name ?? Str::random(10);
        $this->placeholder = $placeholder ?? '';
    }

    public function render()
    {
        return view('components.select');
    }

    private function associativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
