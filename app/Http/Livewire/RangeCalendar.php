<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class RangeCalendar extends Component
{
    public $start_at = null;
    public $end_at = null;
    public $visible = false;

    protected $listeners = ['dateRangeSelected' => 'dateRangeSelected'];

    public function update($start_at, $end_at)
    {
        $start = Carbon::parse($start_at);
        $end = Carbon::parse($end_at);

        if ($start->gt($end)) {
            $this->start_at = $end_at;
            $this->end_at = $start_at;
        } else {
            $this->start_at = $start_at;
            $this->end_at = $end_at;
        }

        $this->visible = false;

        $this->emitUp('dateRangeSelected', $this->start_at, $this->end_at);
    }

    public function toggle()
    {
        $this->visible = !$this->visible;
        if ($this->visible) {
            $this->emit('toggleVisibleCalendar');
        }
    }

    public function render()
    {
        return view('livewire.range-calendar');
    }
}
