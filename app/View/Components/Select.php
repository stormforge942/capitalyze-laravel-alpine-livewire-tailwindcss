<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
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
        public bool $nobutton = false,
        public bool $teleport = false,
        public bool $autoDisable = true,
        public string $btnText = 'Show Result',
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
