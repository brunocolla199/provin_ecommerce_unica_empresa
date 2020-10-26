<?php

namespace App\Http\Controllers;
use App\Services\{GrupoProdutoService, ProdutoService };


class CarrinhoEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $produtoService;

    public function __construct(GrupoProdutoService $grupoProduto, ProdutoService $produto)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->produtoService = $produto;
    }

    public function index()
    {
        $grupos = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);
        
        return view('ecommerce.carrinho.index',compact('grupos'));
    }
}
