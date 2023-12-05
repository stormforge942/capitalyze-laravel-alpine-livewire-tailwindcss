<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DownloadDataButtons extends Component
{
    public bool $requireProAccount = true;
    
    public function render()
    {
        return view('livewire.download-data-buttons');
    }
}
