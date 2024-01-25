<?php

namespace App\Traits;

use App\Models\Navbar;
use App\Models\NavbarGroupShows;
use Illuminate\Support\Collection;

trait HasNavbar
{
    public function hasNavbar($routeName): bool
    {
        $navbar = Navbar::where('route_name', $routeName)->first();

        if (!$navbar?->is_moddable) {
            return true;
        }

        return $navbar->navbarGroupShows()
            ->where('group_id', $this->group_id)
            ->where('show', true)
            ->exists();
    }

    public function navbars($moddable = true): Collection
    {
        return NavbarGroupShows::query()
            ->with(['navbar' => fn ($q) => $q->where('is_moddable', $moddable)])
            ->when(
                fn ($q) => $q->where('group_id', $this->group_id)->where('show', true)
            )
            ->get()
            ->map(fn ($item) => $item->navbar)
            ->filter()
            ->unique('id');
    }
}
