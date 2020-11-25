<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class Announcement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $announcements = \App\Models\Announcement::all();
        View::share("announcements", $announcements);
        return $next($request);
    }
}
