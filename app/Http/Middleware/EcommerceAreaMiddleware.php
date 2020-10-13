<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\Constants;
use Illuminate\Support\Facades\{Auth, Log};

class EcommerceAreaMiddleware
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
        $routeDetails = $request->route()->getAction();
        
        if(Auth::user()->perfil->area_admin == 0) {
            return $next($request);
        } else {
            return response()->view('errors.403');
        }

    }
}
