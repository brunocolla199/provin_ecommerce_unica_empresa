<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class UserInativo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where("email","=",$request->email)->first();
       
        if( $user->inativo == 0) {
            return $next($request);
        } else {
            return response()->view('errors.403');
        }
    }
}
