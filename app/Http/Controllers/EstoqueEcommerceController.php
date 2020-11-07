<?php

namespace App\Http\Controllers;
use App\Services\EstoqueService;
use Illuminate\Support\Facades\Auth;

class EstoqueEcommerceController extends Controller
{
    protected $pedidoService;
    protected $estoqueService;

    protected $grupos;

    
    public function __construct( EstoqueService $estoque)
    {
        
        
        $this->estoqueService = $estoque;


        
    }

    public function index()
    {



        $produtos = $this->estoqueService->findBy(
            [
                ["empresa_id","=",Auth::user()->empresa->id],
                ["quantidade_estoque",">",0,"AND"]
            ]
        );

        return view('ecommerce.estoque.index', [
            'produtos'     => $produtos
        ]);

    }
}
