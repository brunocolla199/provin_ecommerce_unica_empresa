<?php

namespace App\Http\Controllers;
use App\Services\{GrupoProdutoService, ProdutoService, PedidoService };

class CheckoutEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $produtoService;
    protected $pedidoService;

    public $grupos;
    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(GrupoProdutoService $grupoProduto, ProdutoService $produto,PedidoService $pedido)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->produtoService = $produto;
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

        return view('ecommerce.checkout.index',
            [
                'grupos' => $this->grupos,
                'pedidoNormal'  => $this->pedidoNormal,
                'pedidoExpress' => $this->pedidoExpress,
            
            ]
        );
    }
}
