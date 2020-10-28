<?php

namespace App\Http\Controllers;
use App\Services\{GrupoProdutoService, PedidoService, ItemPedidoService };


class CarrinhoEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $pedidoService;
    protected $itemPedidoService;

    public $grupos;
    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(GrupoProdutoService $grupoProduto, PedidoService $pedido, ItemPedidoService $item)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
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


        
        return view('ecommerce.carrinho.index',
            [
                'grupos'        => $this->grupos,
                'pedidoNormal'  => $this->pedidoNormal,
                'pedidoExpress' => $this->pedidoExpress,
                'itens'         => $itens
            ]
        );
    }
}
