<?php

namespace App\Http\Livewire\Euronext;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public function bottomNavKey(): string {
        return 'euronext.';
    }
}
