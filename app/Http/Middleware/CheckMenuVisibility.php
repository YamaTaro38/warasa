<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MenuVisibility;

class CheckMenuVisibility
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();

        if ($routeName) {
            $menu = MenuVisibility::where('route_name', $routeName)->first();

            if ($menu && !$menu->is_visible) {
                abort(403, 'This feature is currently unavailable.');
            }
        }

        return $next($request);
    }
}