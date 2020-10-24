<?php

namespace App\Http\Controllers;

use App\Classes\SetupService;
use Illuminate\Http\Request;
use App\Repositories\GrupoProdutoRepository;
use App\Repositories\ProdutoRepository;
use App\Models\Produto;

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

    public function index(Request $request){
        $produtos = new Produto();

        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $registroPPagina = session()->get('regPorPage') ?? 20;

        $produtos = $produtos->where('inativo','=',0);
        if($request->has('searchProduct')){
            $produtos = $produtos->where('nome','ilike','%' . $request->query('searchProduct') . '%');
        }

        if($request->has('ordenacao')){
            session()->forget('ordenacao');
            session()->put('ordenacao', $request->query('ordenacao'));
            switch($request->query('ordenacao')){
                case 'preco_l_h':
                    $produtos = $produtos->orderBy('valor', 'asc');
                    break;
                case 'preco_h_l':
                    $produtos = $produtos->orderBy('valor', 'desc');
                    break;

            }
        }

        $produtos = $produtos->paginate($registroPPagina)
            ->appends(['searchProduct'=>$request->query('searchProduct')])
            ->appends(['regPorPage'=>$registroPPagina])
            ->appends(['ordenacao'=>$request->query('ordenacao')]);
            
        return view('ecommerce.produto.index',
            [
                'grupos'=> $this->grupos,
                'produtos' => $produtos,
                'totalRegistros' => $produtos->total(),
                'paginaAtual' => $produtos->currentPage(),
                'registroPorPagina' => $produtos->perPage(),
                'totalRegistroPaginaAtual' =>$produtos->count()

            ]
        );
    }

    public function detalhe($id)
    {
        $produto = $this->produtoRepository->find($id);
        $setupService = new SetupService();
        $tamanhos = json_decode($setupService->buscar(1)->tamanhos);
        $tamanhosStr = $setupService->tamanhosToString($tamanhos);
        
        return view('ecommerce.detalheProduto.index', 
            [
                'grupos' => $this->grupos,
                'produto' => $produto,
                'tamanhos' => $tamanhos,
                'tamanhosStr' => $tamanhosStr
            ]
        );
    }

    public function searchGrupo($id, Request $request){
        $produtos = new Produto();
        
        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $registroPPagina = session()->get('regPorPage') ?? 20;

        $produtos = $produtos->where('inativo','=',0);
        if($id){
            $produtos = $produtos->where('grupo_produto_id','=',$id);
        }

        if($request->has('ordenacao')){
            session()->forget('ordenacao');
            session()->put('ordenacao', $request->query('ordenacao'));
            switch($request->query('ordenacao')){
                case 'preco_l_h':
                    $produtos = $produtos->orderBy('valor', 'asc');
                    break;
                case 'preco_h_l':
                    $produtos = $produtos->orderBy('valor', 'desc');
                    break;

            }
        }

        $produtos = $produtos->paginate($registroPPagina)
            ->appends(['regPorPage'=>$registroPPagina])
            ->appends(['ordenacao'=>$request->query('ordenacao')]);
         
        return view('ecommerce.produto.index', 
            [
                'produtos' => $produtos,
                'grupos' => $this->grupos,
                'totalRegistros' => $produtos->total(),
                'paginaAtual' => $produtos->currentPage(),
                'registroPorPagina' => $produtos->perPage(),
                'totalRegistroPaginaAtual' =>$produtos->count()
            ]
        );
    }

    public function searchPreco(Request $request){
        $rangeMinimo  = $request->rangeMinimo;
        $rangeMaximo = $request->rangeMaximo;

        $produtos = new Produto();
        
        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $registroPPagina = session()->get('regPorPage') ?? 20;

        $produtos = $produtos->where('inativo','=',0);
        if($request->has('rangeMaximo') && $request->has('rangeMinimo')){
            $produtos = $produtos->whereBetween('valor', [$rangeMinimo, $rangeMaximo]);
        }

        if($request->has('ordenacao')){
            session()->forget('ordenacao');
            session()->put('ordenacao', $request->query('ordenacao'));
            switch($request->query('ordenacao')){
                case 'preco_l_h':
                    $produtos = $produtos->orderBy('valor', 'asc');
                    break;
                case 'preco_h_l':
                    $produtos = $produtos->orderBy('valor', 'desc');
                    break;

            }
        }
        
        $produtos = $produtos->paginate($registroPPagina)
            ->appends(['rangeMinimo'=>$rangeMinimo])
            ->appends(['rangeMaximo'=>$rangeMaximo])
            ->appends(['regPorPage'=>$registroPPagina])
            ->appends(['ordenacao'=>$request->query('ordenacao')]);
 
        return view('ecommerce.produto.index', 
            [
                'grupos'   => $this->grupos,
                'produtos' => $produtos,
                'totalRegistros' => $produtos->total(),
                'paginaAtual' => $produtos->currentPage(),
                'registroPorPagina' => $produtos->perPage(),
                'totalRegistroPaginaAtual' =>$produtos->count()
            ]
        );
        
        
    }
}

