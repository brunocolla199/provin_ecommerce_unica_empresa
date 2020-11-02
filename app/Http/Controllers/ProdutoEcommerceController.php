<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Produto;
use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\GrupoProdutoService;
use App\Services\ProdutoService;

use App\Services\UserService;
use App\Services\SetupService;
use App\Services\CarrinhoService;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\json_decode;

class ProdutoEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $produtoService;
    protected $setupService;
    protected $carrinhoService;

    protected $pedidoService;
    protected $itemPedidoService;
    protected $userService;

    public $grupos;
    public $tamanhos;
    public $tamanho_padrao;
    public $grupos_necessita_tamanho;
    public $pedidoNormal;
    public $pedidoExpress;
    public $caminhoImagens;
    public $tamanhosStr;

    public function __construct(GrupoProdutoService $grupoProduto, ProdutoService $produto, SetupService $setup, PedidoService $pedidoService, ItemPedidoService $itemPedidoService, UserService $userService, CarrinhoService $carrinho)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->produtoService = $produto;
        $this->setupService = $setup;
        $this->pedidoService = $pedidoService;
        $this->itemPedidoService = $itemPedidoService;
        $this->userService = $userService;
        $this->carrinhoService = $carrinho;

        $this->grupos = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);

        $setup= $this->setupService->find(1);

        

        $this->tamanhos = $setup->tamanhos;
        $this->tamanho_padrao = $setup->tamanho_padrao;
        $this->grupos_necessita_tamanho = $setup->grupos;
        $this->caminhoImagens = $setup->caminho_imagen_produto;
        $this->tamanhosStr = $this->setupService->tamanhosToString(json_decode($this->tamanhos));
    }

    public function index(Request $request){
        $produtos = new Produto();

        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1);

        $rangeMinimo  = $request->rangeMinimo;
        $rangeMaximo = $request->rangeMaximo;
        
        

        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $registroPPagina = session()->get('regPorPage') ?? 20;

        $produtos = $produtos->where('inativo','=',0)->where('quantidade_estoque','>=',1);
        if($request->has('searchProduct')){
            $produtos = $produtos->where('nome','ilike','%' . $request->query('searchProduct') . '%');
        }

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
            ->appends(['searchProduct'=>$request->query('searchProduct')])
            ->appends(['regPorPage'=>$registroPPagina])
            ->appends(['rangeMinimo'=>$rangeMinimo])
            ->appends(['rangeMaximo'=>$rangeMaximo])
            ->appends(['ordenacao'=>$request->query('ordenacao')]);
            
        return view('ecommerce.produto.index',
            [
                'grupos'=> $this->grupos,
                'produtos' => $produtos,
                'pedidoNormal' => $this->pedidoNormal,
                'pedidoExpress'=> $this->pedidoExpress,
                'caminho_imagem' => $this->caminhoImagens,
                'tamanhos' => $this->tamanhos,
                'tamanho_padrao' => $this->tamanho_padrao,
                'grupos_necessita_tamanho' => $this->grupos_necessita_tamanho,
                'totalRegistros' => $produtos->total(),
                'paginaAtual' => $produtos->currentPage(),
                'registroPorPagina' => $produtos->perPage(),
                'totalRegistroPaginaAtual' =>$produtos->count()

            ]
        );
    }

    public function searchGrupo($id, Request $request){
        $produtos = new Produto();

        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1);

        

        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $registroPPagina = session()->get('regPorPage') ?? 20;

        $produtos = $produtos->where('inativo','=',0)->where('quantidade_estoque','>=',1);
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
                'pedidoNormal' => $this->pedidoNormal,
                'pedidoExpress'=> $this->pedidoExpress,
                'caminho_imagem' => $this->caminhoImagens,
                'tamanhos' => $this->tamanhos,
                'tamanho_padrao' => $this->tamanho_padrao,
                'grupos_necessita_tamanho' => $this->grupos_necessita_tamanho,
                'totalRegistros' => $produtos->total(),
                'paginaAtual' => $produtos->currentPage(),
                'registroPorPagina' => $produtos->perPage(),
                'totalRegistroPaginaAtual' =>$produtos->count()
            ]
        );
    }

    public function detalhe($id)
    {
        $produto = $this->produtoService->find($id);
        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1);
        return view('ecommerce.detalheProduto.index', 
            [
                'grupos' => $this->grupos,
                'produto' => $produto,
                'pedidoNormal' => $this->pedidoNormal,
                'pedidoExpress'=> $this->pedidoExpress,
                'tamanhos' => json_decode($this->tamanhos),
                'tamanhosStr' => $this->tamanhosStr,
                'tamanhoDefault' => $this->tamanho_padrao,
                'grupos_necessita_tamanho' => $this->grupos_necessita_tamanho,
                'caminho_imagem' => $this->caminhoImagens
            ]
        );
    }

    public function addCarrinho(Request $request){
        $id_produto  = $request->id;
        $tipo_pedido = $request->tipo == 'express' ? 1: 2;
        $tamanho     = $request->tamanho ?? '';
        $quantidade  = $request->quantidade ?? 1;
        
        $add = $this->carrinhoService->addCarrinho($id_produto,$tipo_pedido,$tamanho, $quantidade);
        if($add){
            return response()->json(['response' => 'successo']);
        }else{
           return response()->json(['response' => 'erro']);
        }
        
    }
    
}