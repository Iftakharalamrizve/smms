<?php

namespace App\Http\Middleware;

use App\Traits\ResponseJsonAble;
use Closure;

class AdminAuthMiddleware
{
   use ResponseJsonAble;
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->tokenCan('role:admin')) {
            return $next($request);
        }

        return $this->respondWithError('Your Credential Is not Correct.');

    }
}
