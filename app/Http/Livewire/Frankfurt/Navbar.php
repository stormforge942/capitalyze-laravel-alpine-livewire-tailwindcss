<?php

namespace App\Http\Livewire\Frankfurt;

use App\Http\Livewire\BaseNavbarComponent;

class Navbar extends BaseNavbarComponent
{
    public function bottomNavKey(): string {
        return 'frankfurt.';
    }
}
