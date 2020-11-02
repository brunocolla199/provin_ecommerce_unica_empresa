<?php

namespace App\Http\Controllers;
use App\Classes\Helper;
use App\Services\{GrupoProdutoService, PedidoService, ItemPedidoService, SetupService, ProdutoService };
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Request;

class CarrinhoEcommerceController extends Controller
{
    protected $grupoProdutoService;
    protected $pedidoService;
    protected $itemPedidoService;
    protected $setupService;
    protected $produtoService;

    public $grupos;
    public $pedidoNormal;
    public $pedidoExpress;

    public function __construct(GrupoProdutoService $grupoProduto, PedidoService $pedido, ItemPedidoService $item, SetupService $setup, ProdutoService $produto)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->setupService = $setup;
        $this->produtoService = $produto;

        $this->grupos = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);
    }

    public function index($id)
    {
        $this->pedidoNormal  = $this->pedidoService->buscaPedidoCarrinho(2);
        $this->pedidoExpress = $this->pedidoService->buscaPedidoCarrinho(1); 

        $itens = $this->itemPedidoService->findBy(
            [
                [
                    'pedido_id','=',$id
                ]
            ]
        );

        $buscaSetup = $this->setupService->find(1);
        $tamanhos   = $buscaSetup['tamanhos'];
        $tamanho_padrao = $buscaSetup['tamanho_padrao'];
        $grupos_necessita_tamanho = $buscaSetup['grupos'];
        $caminho_imagem = $buscaSetup['caminho_imagen_produto'];

        if($itens->count() == 0){
            Helper::setNotify("O carrinho esta vazio.", 'danger|close-circle');
            return redirect()->route('ecommerce.produto');
        }
        
        return view('ecommerce.carrinho.index',
            [
                'grupos'                   => $this->grupos,
                'pedidoNormal'             => $this->pedidoNormal,
                'pedidoExpress'            => $this->pedidoExpress,
                'tamanhos'                 => $tamanhos,
                'tamanho_padrao'           => $tamanho_padrao,
                'grupos_necessita_tamanho' => $grupos_necessita_tamanho,
                'caminho_imagem'           => $caminho_imagem,
                'itens'                    => $itens
            ]
        );
    }

    public function update(Request $request){
        $id  = $request->id;
        $qtd = $request->quantidade;
        $tamanho = $request->tamanho; 

        $buscaItem = $this->itemPedidoService->find($id);

        $verificaEstoque = $this->produtoService->verificaEstoque($buscaItem->produto->id,$qtd);
        if(!$verificaEstoque){
            return response()->json([
                'response' => 'erro',
                'msg'      => 'Estoque insuficiente.'
            ]);
        }

        try {
            DB::transaction(function () use ($buscaItem,$id,$qtd,$tamanho) {
                $this->itemPedidoService->update($id,$buscaItem['pedido_id'],$buscaItem['produto_id'],$qtd,$buscaItem['valor_unitario'],$buscaItem['valor_total'],$tamanho);
                $this->pedidoService->recalcular($buscaItem->pedido->id);
            });    
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o item.", 'danger|close-circle');
            return response()->json([
                'response' => 'erro',
                'msg'      => 'Erro ao atualizar o item.'
            ]);
        }
    }

    public function remove(Request $request){
        $id = trim($request->id);
        $buscaItem = $this->itemPedidoService->find($id);
        try {
            DB::transaction(function () use ($id,$buscaItem) {
                $this->itemPedidoService->delete($id);
                $this->pedidoService->recalcular($buscaItem->pedido->id);
            });
            Helper::setNotify('Produto removido com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao remover o produto.", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        }
    }
}
