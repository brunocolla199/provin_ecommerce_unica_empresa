<?php

namespace App\Http\Controllers;
use App\Classes\Helper;
use App\Services\{PedidoService, ItemPedidoService, SetupService, ProdutoService, CarrinhoService};
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Request;

class CarrinhoEcommerceController extends Controller
{
    protected $pedidoService;
    protected $itemPedidoService;
    protected $setupService;
    protected $produtoService;
    protected $carrinhoService;

    public $grupos;

    public function __construct(PedidoService $pedido, ItemPedidoService $item, SetupService $setup, ProdutoService $produto, CarrinhoService $carrinho)
    {
        $this->middleware('auth');
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->setupService = $setup;
        $this->produtoService = $produto;
        $this->carrinhoService = $carrinho;

        
    }

    public function index($id)
    {


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

        if($qtd >= $buscaItem->quantidade){
            $verificaEstoque = $this->produtoService->verificaEstoque($buscaItem->produto->id,$qtd - $buscaItem->quantidade);
            if(!$verificaEstoque){
                return response()->json([
                    'response' => 'erro',
                    'msg'      => 'Estoque insuficiente.'
                ]);
            }
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
    
        if($this->carrinhoService->removerCarrinho($id))
        {
            return response()->json(['response' => 'sucesso']);
        }else{
            return response()->json(['response' => 'erro']);
        }   
    }

    public function buscaItem($id){
        $item = $this->itemPedidoService->find($id);
        return response()->json(
            [
                'response' => 'successo',
                'data' => [
                    'quantidade' => $item->quantidade,
                ]
            ]
        );
    }
}
