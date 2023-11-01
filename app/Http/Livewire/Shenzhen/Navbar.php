<?php

namespace App\Http\Livewire\Shenzhen;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public bool $hasQuarterly = false;

    public function bottomNavKey(): string {
        return 'shenzhen.';
    }
}
