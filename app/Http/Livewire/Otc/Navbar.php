<?php

namespace App\Http\Livewire\Otc;

use App\Http\Livewire\BaseNavbar;

class Navbar extends BaseNavbar
{
    public function bottomNavKey(): string {
        return 'otc.';
    }
}
