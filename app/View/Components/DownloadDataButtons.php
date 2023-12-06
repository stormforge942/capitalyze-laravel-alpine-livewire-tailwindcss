<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DownloadDataButtons extends Component
{
    public function __construct(
        public bool $requireProAccount = true,
    ) {
    }

    public function render()
    {
        return view('components.download-data-buttons');
    }
}
