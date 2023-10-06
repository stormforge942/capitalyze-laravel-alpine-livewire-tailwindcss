<?php

namespace App\Http\Livewire\Shanghai;

use App\Http\Livewire\BaseNavbar;

class Navbar extends BaseNavbar
{
    public function bottomNavKey(): string {
        return 'shanghai.';
    }
}
