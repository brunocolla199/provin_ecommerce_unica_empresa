<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Produto;
use App\Services\GrupoProdutoService;
use App\Services\ProdutoService;

use App\Services\SetupService;
use App\Services\CarrinhoService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\json_decode;
use App\Services\PedidoService;
use App\Services\EstoqueService;
use Illuminate\Support\Facades\DB;

class ProdutoEcommerceController extends Controller
{
    public $grupos;
    public $tamanhos;
    public $tamanho_padrao;
    public $grupos_necessita_tamanho;
    public $caminhoImagens;
    public $tamanhosStr;
    public $setupService;

    public function __construct()
    {
        //$this->middleware('auth');

        $grupoProdutoService = new GrupoProdutoService();
        $this->setupService = new SetupService();
        $this->grupos = $grupoProdutoService->findBy([
            ['inativo','=',0]
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
        $produtos = $produtos->join('estoque', 'estoque.produto_id', '=', 'produto.id')->where('produto.inativo','=',0)->where('produto.existe_foto','=',true)->where('estoque.quantidade_estoque','>=',1)->where('estoque.valor','>',0);
        $rangeMinimo  = $request->rangeMinimo;
        $rangeMaximo = $request->rangeMaximo;
        
        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $registroPPagina = session()->get('regPorPage') ?? 20;

        $userService = new UserService();
        $produtos = $produtos->where('estoque.empresa_id','=',$userService->getEmpresa());
        
        
        if($request->has('searchProduct') && !empty($request->searchProduct)){
            $produtos->where(function($query) use($request){
                $query->where('produto.nome','ilike','%' . $request->query('searchProduct') . '%')
                    ->orwhere('produto.produto_terceiro','ilike','%' . $request->query('searchProduct') . '%');
            });
            
        }
        
        /*
        if($request->has('rangeMaximo') && $request->has('rangeMinimo')){
            $produtos = $produtos->whereBetween('estoque.valor', [$rangeMinimo, $rangeMaximo]);
        }
        */

        if($request->has('ordenacao') && !empty($request->ordenacao)){
            session()->forget('ordenacao');
            session()->put('ordenacao', $request->query('ordenacao'));
            switch($request->query('ordenacao')){
                case 'preco_l_h':
                    $produtos = $produtos->orderBy('estoque.valor', 'asc');
                    break;
                case 'preco_h_l':
                    $produtos = $produtos->orderBy('estoque.valor', 'desc');
                    break;

            }
        }else{
            $produtos = $produtos->orderBy('estoque.valor', 'desc');
        }
        
        $filtrosSelecionados = [];
        foreach ($this->grupos as $key => $value) {
            array_push($filtrosSelecionados, $value->id);
        }

        $produtos = $produtos->paginate($registroPPagina)
            ->appends(['searchProduct'=>$request->query('searchProduct')])
            ->appends(['regPorPage'=>$registroPPagina])
            ->appends(['rangeMinimo'=>$rangeMinimo])
            ->appends(['rangeMaximo'=>$rangeMaximo])
            ->appends(['ordenacao'=>$request->query('ordenacao')]);

          
        $pedidoService = new PedidoService();
        $pedidoNormal = Auth::check() ? $pedidoService->buscaPedidoCarrinho(2) : [];
        $pedidoExpress = Auth::check() ? $pedidoService->buscaPedidoCarrinho(1) : [];

        
        return view('ecommerce.produto.index',
            [
                'filtrosSelecionados' => $filtrosSelecionados,
                'grupos'=> $this->grupos,
                'produtos' => $produtos,
                'caminho_imagem' => $this->caminhoImagens,
                'pedidoNormal'  => $pedidoNormal[0]->id ?? 0,
                'pedidoExpresso'  => $pedidoExpress[0]->id ?? 0,
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
        $produtos = $produtos->join('estoque', 'estoque.produto_id', '=', 'produto.id');
        if($request->query('regPorPage')){
            session()->forget('regPorPage');
            session()->put('regPorPage', $request->query('regPorPage'));
        }

        $userService = new UserService();
        $produtos = $produtos->where('estoque.empresa_id','=',$userService->getEmpresa());
        

        $registroPPagina = session()->get('regPorPage') ?? 20;
        $produtos = $produtos->where('produto.inativo','=',0)->where('estoque.quantidade_estoque','>=',1)->where('estoque.valor','>',0);
        if($id){
            $produtos = $produtos->where('produto.grupo_produto_id','=',$id);
        }

        if($request->has('ordenacao')){
            session()->forget('ordenacao');
            session()->put('ordenacao', $request->query('ordenacao'));
            switch($request->query('ordenacao')){
                case 'preco_l_h':
                    $produtos = $produtos->orderBy('estoque.valor', 'asc');
                    break;
                case 'preco_h_l':
                    $produtos = $produtos->orderBy('estoque.valor', 'desc');
                    break;
            }
        }else{
            $produtos = $produtos->orderBy('estoque.valor', 'desc');
        }

        $filtrosSelecionados = [$id];

        $pedidoService = new PedidoService();
        $pedidoNormal = Auth::check() ? $pedidoService->buscaPedidoCarrinho(2) : [];
        $pedidoExpress = Auth::check() ? $pedidoService->buscaPedidoCarrinho(1) : [];

        $produtos = $produtos->where('produto.inativo','=',0)->where('produto.existe_foto','=',true)->where('estoque.quantidade_estoque','>=',1)->where('estoque.valor','>',0)->paginate($registroPPagina)
            ->appends(['regPorPage'=>$registroPPagina])
            ->appends(['ordenacao'=>$request->query('ordenacao')]);
         
        return view('ecommerce.produto.index', 
            [
                'produtos' => $produtos,
                'grupos' => $this->grupos,
                'filtrosSelecionados' => $filtrosSelecionados,
                'caminho_imagem' => $this->caminhoImagens,
                'pedidoNormal'  => $pedidoNormal[0]->id ?? 0,
                'pedidoExpresso'  => $pedidoExpress[0]->id ?? 0,
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
        $produtoService = new ProdutoService();
        $pedidoService = new PedidoService();
        $produto = $produtoService->find($id);

        $estoqueService = new EstoqueService();
        $estoque = $estoqueService->getEstoque($id);

        
        $pedidoNormal = Auth::check() ? $pedidoService->buscaPedidoCarrinho(2) : [];
        $pedidoExpress = Auth::check() ? $pedidoService->buscaPedidoCarrinho(1) : [];


        return view('ecommerce.detalheProduto.index', 
            [
                'grupos' => $this->grupos,
                'produto' => $produto,
                'estoque' => $estoque->quantidade_estoque ?? 0,
                'valor'   => $estoque->valor,
                'tamanhos' => json_decode($this->tamanhos),
                'tamanhosStr' => $this->tamanhosStr,
                'tamanhoDefault' => $this->tamanho_padrao,
                'grupos_necessita_tamanho' => $this->grupos_necessita_tamanho,
                'caminho_imagem' => $this->caminhoImagens,
                'pedidoNormal'  => $pedidoNormal[0]->id ?? 0,
                'pedidoExpresso'  => $pedidoExpress[0]->id ?? 0,
            ]
        );
    }

    public function addCarrinho(Request $request){
        $id_produto  = $request->id;
        $tipo_pedido = $request->tipo == 'express' ? 1: 2;
        $tamanho     = $request->tamanho ?? null;
        $quantidade  = $request->quantidade ?? 1;
        $carrinhoService = new CarrinhoService();
        $add = $carrinhoService->addCarrinho($id_produto,$tipo_pedido,$tamanho, $quantidade);
        if($add != false){
            return response()->json(['response' => 'successo', 'data'=> $add]);
        }else{
           return response()->json(['response' => 'erro']);
        }
    }

    public function buscaProduto(Request $request)
    {
        $estoqueService = new EstoqueService();
        $idProduto = $request->id;
        $produto = $estoqueService->findOneBy(
            [
                ['produto_id', '=', $idProduto],
                ['empresa_id', '=', Auth::user()->empresa_id]
            ]
        );
        return response()->json(
            [
                'response' => 'successo',
                'data' => [
                    'quantidade_estoque' => $produto->quantidade_estoque,
                    'preco' => $produto->valor
                ]
            ]
        );

    }

    public function updateEstoque (Request $request)
    {
        $idProduto  = $request->id;
        $quantidade = $request->quantidade;
        $operacao   = $request->operacao;
        $retorno = '';
        try {
            $estoqueService = new EstoqueService();
            $buscaProduto = $estoqueService->findOneBy(
                [
                    ['produto_id', '=', $idProduto],
                    ['empresa_id', '=', Auth::user()->empresa_id]
                ]
            );
            $update = $estoqueService->update(
            [
                "quantidade_estoque" => $operacao == 'A' ? $buscaProduto->quantidade_estoque +$quantidade : $buscaProduto->quantidade_estoque - $quantidade
            ],
            $buscaProduto->id);
            
            $retorno = 'successo';
        } catch (\Throwable $th) {
            dd($th);
            $retorno = 'erro';
        }

        return response()->json(
            [
                'response' => $retorno
            ]
        );
        
            
    }

    public function verificaFoto(Request $request)
    {
        $idProdutoTerceiro = $request->id;
        $tipo = $request->tipo;
        $setup = $this->setupService->find(1);
        $retorno = asset('ecommerce/assets/img/212X200/img1.jpg');
        
        if($tipo == 'Entrada'){
            if(file_exists(public_path($setup->caminho_imagen_produto.'/'.$idProdutoTerceiro.'_2.jpeg'))){
                $retorno = asset($setup->caminho_imagen_produto.'/'.$idProdutoTerceiro.'_2.jpeg');
            }
        }else {
            if(file_exists(public_path($setup->caminho_imagen_produto.'/'.$idProdutoTerceiro.'.jpeg'))){
                $retorno = asset($setup->caminho_imagen_produto.'/'.$idProdutoTerceiro.'.jpeg');
            }
        }

        return response()->json(
            [
                'response' => 'successo',
                'data' => [
                    'caminho' => $retorno
                ]
            ]
        );
    }
    
}