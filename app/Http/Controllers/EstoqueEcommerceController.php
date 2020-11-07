<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;

use App\Services\EstoqueService;
use Illuminate\Support\Facades\Auth;

class EstoqueEcommerceController extends Controller
{
    protected $pedidoService;
    protected $estoqueService;

    protected $grupos;
    private $pedidoNormal;
    private $pedidoExpress;
    
    public function __construct(PedidoService $pedido, EstoqueService $estoque)
    {
        $this->pedidoService = $pedido;
        
        $this->estoqueService = $estoque;


        
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
            'pedidoNormal' => $this->pedidoNormal,
            'pedidoExpress'=> $this->pedidoExpress,
            'produtos'     => $produtos
        ]);

    }
}
