<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;
use App\Services\GrupoProdutoService;

class EstoqueEcommerceController extends Controller
{
    protected $pedidoService;
    protected $grupoProdutoService;

    protected $grupos;
    private $pedidoNormal;
    private $pedidoExpress;
    
    public function __construct(PedidoService $pedido, GrupoProdutoService $grupoProduto)
    {
        $this->pedidoService = $pedido;
        $this->grupoProdutoService = $grupoProduto;
        
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

        return view('ecommerce.estoque.index', [
            'grupos'       => $this->grupos,
            'pedidoNormal' => $this->pedidoNormal,
            'pedidoExpress'=> $this->pedidoExpress
        ]);

    }
}
