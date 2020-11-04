<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Repositories\PedidoRepository;
use Illuminate\Support\Facades\{Auth};

class CarrinhoEmpresaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     protected $pedidoRepository;

     public function __construct(PedidoRepository $pedido)
     {
         $this->pedidoRepository = $pedido;
     }

    public function handle(Request $request, Closure $next)
    {
        $idPedido = $request->id;
        $buscaPedido = $this->pedidoRepository->find($idPedido);

        if( Auth::user()->empresa->id == $buscaPedido->usuario->empresa->id) {
            return $next($request);
        } else {
            return response()->view('errors.403');
        }
    }
}
