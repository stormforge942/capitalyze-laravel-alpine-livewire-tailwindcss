<?php

namespace App\Http\Livewire\Tsx;

use App\Http\Livewire\BaseNavbar;

class Navbar extends BaseNavbar
{
    public function bottomNavKey(): string {
        return 'tsx.';
    }
}
