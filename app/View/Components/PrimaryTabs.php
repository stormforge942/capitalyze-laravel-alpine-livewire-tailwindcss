<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PrimaryTabs extends Component
{
    public array $tabs = [];
    public ?string $active = null;
    public bool $triggerChange = false;

    public function __construct(
        array $tabs = [],
        ?string $active = null,
        public ?string $minWidth = '250px',
        public array $badges = [],
        public string $queryLabel = 'tab'
    ) {
        if (!is_array(array_values($tabs)[0])) {
            $tabs_ = [];

            foreach ($tabs as $key => $title) {
                $tabs_[$key] = [
                    'title' => $title,
                    'key' => $key,
                ];
            }

            $this->tabs = $tabs_;
        } else {
            $this->tabs = $tabs;
        }

        if ($active && !in_array($active, array_keys($this->tabs))) {
            $this->triggerChange = true;
        }

        if ($active && in_array($active, array_keys($this->tabs))) {
            $this->active = $active;
        } else {
            $this->active = array_key_first($this->tabs);
        }
    }

    public function render()
    {
        return view('components.primary-tabs');
    }
}
