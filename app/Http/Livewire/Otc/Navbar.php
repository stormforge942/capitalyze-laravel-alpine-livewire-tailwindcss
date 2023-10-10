<?php

namespace App\Http\Livewire\Otc;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public function bottomNavKey(): string {
        return 'otc.';
    }
}
