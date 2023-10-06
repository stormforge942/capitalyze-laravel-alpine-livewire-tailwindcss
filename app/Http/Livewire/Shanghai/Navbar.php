<?php

namespace App\Http\Livewire\Shanghai;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public function bottomNavKey(): string {
        return 'shanghai.';
    }
}
