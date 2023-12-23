<?php

namespace App\Traits;

use App\Models\Navbar;
use App\Models\NavbarGroupShows;
use Illuminate\Support\Collection;

trait HasNavbar
{
    public function hasNavbar($routeName): bool
    {
        return Navbar::where('route_name', $routeName)
            ->where('is_moddable', true)
            ->whereHas(
                'navbarGroupShows',
                fn ($query) => $query
                    ->where('navbar_group_shows.group_id', $this->group_id)
                    ->where('navbar_group_shows.show', true)
            )
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
