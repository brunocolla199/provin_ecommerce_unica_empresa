<?php

namespace App\Http\Controllers;
use App\Services\{GrupoProdutoService, PedidoService, ItemPedidoService, SetupService };
use function GuzzleHttp\json_encode;

class CarrinhoEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $pedidoService;
    protected $itemPedidoService;
    protected $setupService;

    public $grupos;
    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(GrupoProdutoService $grupoProduto, PedidoService $pedido, ItemPedidoService $item, SetupService $setup)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->setupService = $setup;

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

        $buscaSetup = $this->setupService->find(1);
        $tamanhos   = $buscaSetup['tamanhos'];
        $tamanho_padrao = $buscaSetup['tamanho_padrao'];
        $grupos_necessita_tamanho = $buscaSetup['grupos'];
        
        
        return view('ecommerce.carrinho.index',
            [
                'grupos'                   => $this->grupos,
                'pedidoNormal'             => $this->pedidoNormal,
                'pedidoExpress'            => $this->pedidoExpress,
                'tamanhos'                 => $tamanhos,
                'tamanho_padrao'           => $tamanho_padrao,
                'grupos_necessita_tamanho' => $grupos_necessita_tamanho,
                'itens'                    => $itens
            ]
        );
    }
}
