<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class ShareholderHoldings extends Component
{
    use AsTab;

    public static function title(): string
    {
        return 'Holdings';
    }

    public function render()
    {
        return view('livewire.ownership.shareholder-holdings');
    }
}
