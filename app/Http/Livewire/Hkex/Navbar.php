<?php

namespace App\Http\Livewire\Hkex;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public function bottomNavKey(): string {
        return 'hkex.';
    }
}
