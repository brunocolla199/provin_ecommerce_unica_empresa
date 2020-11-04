<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;
use App\Services\GrupoProdutoService;
use App\Services\EstoqueService;
use Illuminate\Support\Facades\Auth;

class EstoqueEcommerceController extends Controller
{
    protected $pedidoService;
    protected $grupoProdutoService;
    protected $estoqueService;

    protected $grupos;
    private $pedidoNormal;
    private $pedidoExpress;
    
    public function __construct(PedidoService $pedido, GrupoProdutoService $grupoProduto, EstoqueService $estoque)
    {
        $this->pedidoService = $pedido;
        $this->grupoProdutoService = $grupoProduto;
        $this->estoqueService = $estoque;

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

        $produtos = $this->estoqueService->findBy(
            [
                ["empresa_id","=",Auth::user()->empresa->id],
                ["quantidade_estoque",">",0,"AND"]
            ]
        );

        return view('ecommerce.estoque.index', [
            'grupos'       => $this->grupos,
            'pedidoNormal' => $this->pedidoNormal,
            'pedidoExpress'=> $this->pedidoExpress,
            'produtos'     => $produtos
        ]);

    }
}
