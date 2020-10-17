<?php

namespace App\Http\Controllers;
use App\Repositories\{GrupoProdutoRepository, ProdutoRepository };
use Illuminate\Http\Request;

class CarrinhoEcommerceController extends Controller
{
    protected $grupoProdutoRepository;
    protected $produtoRepository;

    public function __construct(GrupoProdutoRepository $grupoProduto, ProdutoRepository $produto)
    {
        $this->middleware('auth');
        $this->grupoProdutoRepository = $grupoProduto;
        $this->produtoRepository = $produto;
    }

    public function index()
    {
        $grupos = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
        
        return view('ecommerce.carrinho.index',compact('grupos'));
    }
}
