<?php

namespace App\Http\Controllers;
use App\Services\EstoqueService;
use Illuminate\Support\Facades\Auth;
use App\Services\SetupService;

class EstoqueEcommerceController extends Controller
{
    protected $pedidoService;
    protected $estoqueService;
    protected $setupService;

    
    public function __construct( EstoqueService $estoque, SetupService $setup)
    {
        
        
        $this->estoqueService = $estoque;
        $this->setupService   = $setup;

        
    }

    public function index()
    {

        $setup = $this->setupService->find(1);

        $produtos = $this->estoqueService->findBy(
            [
                ["empresa_id","=",Auth::user()->empresa->id],
                ["quantidade_estoque",">",0,"AND"]
            ]
        );

        return view('ecommerce.estoque.index', [
            'produtos'       => $produtos,
            'caminho_imagem' => $setup->caminho_imagen_produto
        ]);

    }
}
