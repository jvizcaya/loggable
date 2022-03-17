<?php

namespace Jvizcaya\Loggable\Middleware;

use Illuminate\Support\Facades\Gate;

class Authorize
{
    /**
     * Authorize the current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return Gate::check('viewLoggableDashboard', [$request->user()])
            ? $next($request)
            : abort(403);
    }
}
