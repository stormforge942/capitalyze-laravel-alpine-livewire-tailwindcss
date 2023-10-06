<?php

namespace App\Http\Livewire\Frankfurt;

use App\Http\Livewire\BaseNavbar;

class Navbar extends BaseNavbar
{
    public function bottomNavKey(): string {
        return 'frankfurt.';
    }
}
