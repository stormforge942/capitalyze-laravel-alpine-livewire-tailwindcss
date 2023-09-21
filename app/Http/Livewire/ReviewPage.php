<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReviewPage extends Component
{
    public $reportId = null;
    public $openSlider = false;

    protected $listeners = [
        'toggle-slider' => 'toggleSlider',
        'close-slider' => 'closeSlider'
    ];

    public function toggleSlider($args)
    {
        [$id] = $args;
        if ($id)
        {
            $this->reportId = $args[0];
        }

        $this->openSlider = !$this->openSlider;
    }

    public function closeSlider()
    {
        $this->openSlider = false;
        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.review-page');
    }
}
