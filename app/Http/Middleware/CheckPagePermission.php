<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Navbar;
use App\Models\Groups;
use App\Models\NavbarGroupShows;

class CheckPagePermission
{
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        $navbar = Navbar::where('route_name', $routeName)->first();

        $navbarGroupShows = NavbarGroupShows::where('navbar_id', $navbar->id)->get();

        if ($navbar && count($navbarGroupShows) === 0) {
            return redirect()->route('permission-denied');
        }

        foreach ($navbarGroupShows as $item) {
            if ($item && $item->group_id === Auth::user()->group_id && $item->show === false) {
                return redirect()->route('permission-denied');
            }
        }

        return $next($request);
    }
}
