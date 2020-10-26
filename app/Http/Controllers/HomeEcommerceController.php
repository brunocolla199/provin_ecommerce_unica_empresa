<?php

namespace App\Http\Controllers;

use App\Services\GrupoProdutoService;
use App\Services\PedidoService;

class HomeEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $pedidoService;
    public $grupos;

    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(GrupoProdutoService $grupoProduto, PedidoService $pedido)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->pedidoService = $pedido;

        $this->grupos = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);

        
        
    }

    public function index()
    {
        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1); 

        return view('ecommerce.home.index',
            [
                'grupos'       => $this->grupos,
                'pedidoNormal' => $this->pedidoNormal,
                'pedidoExpress'=> $this->pedidoExpress
            ]
        );
    }
}
