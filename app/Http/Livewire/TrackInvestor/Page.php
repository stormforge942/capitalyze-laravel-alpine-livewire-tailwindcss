<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.track-investor.page', [
            'tabs' => [
                Discover::class,
                Favorites::class,
            ],
        ]);
    }
}
