<?php

namespace App\Http\Controllers;


use App\Services\PedidoService;


class HomeEcommerceController extends Controller
{
    protected $pedidoService;
    

    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(PedidoService $pedido)
    {
        $this->middleware('auth');
        
        $this->pedidoService = $pedido; 
        
    }

    public function index()
    {
        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1); 

        return view('ecommerce.home.index',
            [
                'pedidoNormal' => $this->pedidoNormal,
                'pedidoExpress'=> $this->pedidoExpress
            ]
        );
    }
}
