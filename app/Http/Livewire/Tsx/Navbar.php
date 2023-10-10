<?php

namespace App\Http\Livewire\Tsx;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public function bottomNavKey(): string {
        return 'tsx.';
    }
}
