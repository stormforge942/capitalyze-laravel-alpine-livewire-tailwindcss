<?php

namespace App\Http\Livewire\Screener;

use App\Http\Livewire\Builder\Chart;
use App\Models\CompanyChartComparison;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScreenerPrimaryTabs extends Component
{
    public array $tabs = [];
    public ?string $active = null;
    public bool $triggerChange = false;
    public string $minWidth = '250px';
    public array $badges = [];

    public function mount(array $tabs, $active = null, $minWidth = '250px') {
        if (!is_array(array_values($this->tabs)[0])) {
            $tabs_ = [];

            foreach ($this->tabs as $key => $title) {
                $tabs_[$key] = [
                    'title' => $title,
                    'key' => $key,
                ];
            }

            $this->tabs = $tabs_;
        } else {
            $this->tabs = $tabs;
        }

        if ($this->active && !in_array($active, array_keys($this->tabs))) {
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
        return view('livewire.screener.screener-primary-tabs');
    }
}
