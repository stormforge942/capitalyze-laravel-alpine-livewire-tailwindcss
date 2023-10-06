<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseNavbar;

class Navbar extends BaseNavbar
{
    public function bottomNavKey(): string {
        return 'lse.';
    }
}
