<?php

namespace App\Http\Livewire\Hkex;

use App\Http\Livewire\BaseNavbar;

class Navbar extends BaseNavbar
{
    public function bottomNavKey(): string {
        return 'hkex.';
    }
}
