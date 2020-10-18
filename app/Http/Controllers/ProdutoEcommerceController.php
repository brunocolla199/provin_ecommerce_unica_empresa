<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GrupoProdutoRepository;
use App\Repositories\ProdutoRepository;

class ProdutoEcommerceController extends Controller
{
    protected $grupoProdutoRepository;
    protected $produtoRepository;
    public $grupos;
    

    public function __construct(GrupoProdutoRepository $grupoProduto, ProdutoRepository $produto)
    {
        $this->middleware('auth');
        $this->grupoProdutoRepository = $grupoProduto;
        $this->produtoRepository = $produto;

        $this->grupos = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
        
    }

    public function index(){
        $produtos = $this->produtoRepository->findBy(
            [
                [
                'inativo','=',0
                ]
            ],
            [],[],[],
            20,0
        );

        
        return view('ecommerce.produto.index',
            [
                'grupos'=> $this->grupos,
                'produtos' => $produtos
            ]
        );
    }

    public function detalhe($id)
    {
        $produto = $this->produtoRepository->find($id);
        
        return view('ecommerce.detalheProduto.index', 
            [
                'grupos' => $this->grupos,
                'produto' => $produto
            ]
        );
    }

    public function searchGrupo($id){
        $produtos = $this->produtoRepository->findBy(
            [
                [
                'grupo_produto_id','=',$id
                ],
                [
                    'inativo','=',0,'AND'
                ]
            ],
            [],[],[],
            20,0
        );
        return view('ecommerce.produto.index', 
            [
                'produtos' => $produtos,
                'grupos' => $this->grupos
            ]
        );
    }

    public function searchNome(Request $request){
        $nome = $request->searchProduct;
        
        $produtos =  $this->produtoRepository->findBy(
            [
                [
                    'nome','ilike','%' . $nome . '%' 
                ]
            ],
            [],[],[],
            20,0
        );

        return view('ecommerce.produto.index', 
            [
                'grupos'   => $this->grupos,
                'produtos' => $produtos
            ]
        );
        
    }

    public function searchPreco(Request $request){
        $rangeMinimo  = $request->rangeMinimo;
        $rangeMaximo = $request->rangeMaximo;

        //$query->whereBetween('age', [$ageFrom, $ageTo]);
        
        $produtos =  $this->produtoRepository->findBy(
            [
                [
                    'nome','ilike','%' . $nome . '%' 
                ]
            ],
            [],[],[],
            20,0
        );

        /*
        return view('ecommerce.produto.index', 
            [
                'grupos'   => $this->grupos,
                'produtos' => $produtos
            ]
        );
        */
        
    }
}

