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
        // Get the current route name
        $routeName = $request->route()->getName();

        // Check if the route has a corresponding record in the Navbar model
        $navbar = Navbar::where('route_name', $routeName)->first();

        $navbarGroupShows = NavbarGroupShows::where('navbar_id', $navbar->id)->get();

        foreach ($navbarGroupShows as $item) {
            if ($item && $item->group_id === Auth::user()->group_id && $item->show === false) {
                return redirect()->route('permission-denied');
            }
        }

        return $next($request);
    }
}
