<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class ShareholderSummary extends Component
{
    use AsTab;

    public static function title(): string
    {
        return 'Summary';
    }

    public function render()
    {
        return view('livewire.ownership.shareholder-summary');
    }
}
