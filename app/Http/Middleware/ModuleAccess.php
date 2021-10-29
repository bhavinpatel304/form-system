<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Common;
use Closure;

class ModuleAccess
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
        if (!Common::isAdmin()) {
            return redirect('admin/dashboard')->withMsgFailed(env('MSG_NOT_AUTHORISED'));
        }
        return $next($request);
    }
}
