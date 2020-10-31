<?php

namespace App\Http\Controllers;
use App\Services\{GrupoProdutoService, ProdutoService, PedidoService,ItemPedidoService };

class CheckoutEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $produtoService;
    protected $pedidoService;
    protected $itemPedidoService;

    public $grupos;
    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(GrupoProdutoService $grupoProduto, ProdutoService $produto,PedidoService $pedido,ItemPedidoService $item)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->produtoService = $produto;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;

        $this->grupos = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);
    }

    public function index($id)
    {
        
        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1); 

        $itens = $this->itemPedidoService->findBy(
            [
                [
                    'pedido_id','=',$id
                ]
            ]
        );

        return view('ecommerce.checkout.index',
            [
                'itens'  => $itens,
                'grupos' => $this->grupos,
                'pedidoNormal'  => $this->pedidoNormal,
                'pedidoExpress' => $this->pedidoExpress,
            
            ]
        );
    }
}
