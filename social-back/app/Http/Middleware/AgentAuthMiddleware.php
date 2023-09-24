<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ResponseJsonAble;
class AgentAuthMiddleware
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
        if (auth()->user()->tokenCan('role:agent')) {
            return $next($request);
        }

        return $this->respondWithError('Your Credential Is not Correct.');

    }
}
