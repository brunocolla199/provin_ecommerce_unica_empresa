<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GrupoProdutoRepository;
use App\Repositories\ProdutoRepository;

class ProdutoEcommerceController extends Controller
{
    protected $grupoProdutoRepository;
    protected $produtoRepository;

    public function __construct(GrupoProdutoRepository $grupoProduto, ProdutoRepository $produto)
    {
        $this->middleware('auth');
        $this->grupoProdutoRepository = $grupoProduto;
        $this->produtoRepository = $produto;

    }

    public function index(){
        $produtos = $this->produtoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);

        $grupos = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
        return view('ecommerce.produto.index',compact('grupos','produtos'));
    }

    public function detalhe($id)
    {
        $produto = $this->produtoRepository->find($id);
        $grupos = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
        
        return view('ecommerce.detalheProduto.index', compact('produto','grupos'));
    }
}
