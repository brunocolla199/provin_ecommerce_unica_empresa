<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth};

class ListarPedidoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */



     public function __construct()
     {
         
     }

    public function handle(Request $request, Closure $next)
    {
        
        if( Auth::user()->perfil->eco_listar_pedido == 1) {
            return $next($request);
        } else {
            return response()->view('errors.403');
        }
    }
}
