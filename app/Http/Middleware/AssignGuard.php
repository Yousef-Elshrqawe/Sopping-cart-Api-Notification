<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;

class AssignGuard
{
    use GeneralTrait;

    public function handle($request, Closure $next, $guard = null)
    {
        if($guard != null){
            auth()->shouldUse($guard);
            return $next($request);

        }
    }
}
