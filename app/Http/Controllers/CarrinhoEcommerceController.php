<?php

namespace App\Http\Controllers;
use App\Classes\Helper;
use App\Services\{PedidoService, ItemPedidoService, SetupService, ProdutoService, CarrinhoService, EstoqueService};
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Request;

class CarrinhoEcommerceController extends Controller
{
    public $grupos;

    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function index(Request $request, $id)
    {
        if($request->getMethod () != 'GET'){
            return redirect()->route('ecommerce.produto');
        }
        $itemPedidoService = new ItemPedidoService();
        $itens = $itemPedidoService->findBy(
            [
                [
                    'pedido_id','=',$id
                ]
            ]
        );

        $setupService = new SetupService();
        $buscaSetup = $setupService->find(1);
        $tamanhos   = $buscaSetup['tamanhos'];
        $tamanho_padrao = $buscaSetup['tamanho_padrao'];
        $grupos_necessita_tamanho = $buscaSetup['grupos'];
        $caminho_imagem = $buscaSetup['caminho_imagen_produto'];

        $porcentagemAcrescimos = $buscaSetup['valor_adicional_pedido'];

        if($itens->count() == 0){
            //Helper::setNotify("O carrinho esta vazio.", 'danger|close-circle');
            return redirect()->route('ecommerce.produto');
            
        }
        
        return view('ecommerce.carrinho.index',
            [
                'tamanhos'                 => $tamanhos,
                'tamanho_padrao'           => $tamanho_padrao,
                'grupos_necessita_tamanho' => $grupos_necessita_tamanho,
                'caminho_imagem'           => $caminho_imagem,
                'itens'                    => $itens,
                'porcentagemAcrescimos'    => $porcentagemAcrescimos
            ]
        );
    }

    public function update(Request $request){
        $id  = $request->id;
        $qtd = $request->quantidade;
        $tamanho = $request->tamanho; 

        $itemPedidoService = new ItemPedidoService();
        $produtoService = new ProdutoService();
        $buscaItem = $itemPedidoService->find($id);

        if($qtd >= $buscaItem->quantidade){
            $verificaEstoque = $produtoService->verificaEstoque($buscaItem->produto->id,$qtd - $buscaItem->quantidade);
            if(!$verificaEstoque){
                return response()->json([
                    'response' => 'erro',
                    'msg'      => 'Estoque insuficiente.'
                ]);
            }
        }
        
        try {
            DB::transaction(function () use ($itemPedidoService, $buscaItem,$id,$qtd,$tamanho) {
                $itemPedidoService->update($id,$buscaItem['pedido_id'],$buscaItem['produto_id'],$qtd,$buscaItem['valor_unitario'],$buscaItem['valor_total'],$tamanho);
                $pedidoService = new PedidoService(); 
                $pedidoService->recalcular($buscaItem->pedido->id);
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
        $id = $request->id;
        $carrinhoService = new CarrinhoService();
        if($carrinhoService->removerCarrinho($id))
        {
            return response()->json(['response' => 'sucesso']);
        }else{
            return response()->json(['response' => 'erro']);
        }   
    }

    public function buscaItem(Request $request){
        $id = $request->id;

        $itemPedidoService = new ItemPedidoService();
        $item = $itemPedidoService->find($id);
        return response()->json(
            [
                'response' => 'successo',
                'data' => [
                    'quantidade' => $item->quantidade,
                ]
            ]
        );
    }

    public function detalheItem($id_pedido, $id_item)
    {
        $itemPedidoService = new ItemPedidoService();
        $setupService = new SetupService();

        $item = $itemPedidoService->find($id_item);
        $setup= $setupService->find(1);

        $estoqueService = new EstoqueService();
        $estoque = $estoqueService->getEstoque($item->produto->id);
       
        return view('ecommerce.detalheProdutoCarrinho.index', 
            [
                'item' => $item,
                'estoque' => $estoque->quantidade_estoque,
                'tamanhos' => json_decode($setup->tamanhos),
                'tamanhosStr' => $setupService->tamanhosToString(json_decode($setup->tamanhos)),
                'tamanhoDefault' => $setup->tamanho_padrao,
                'grupos_necessita_tamanho' => $setup->grupos,
                'caminho_imagem' => $setup->caminho_imagen_produto
            ]
        );
    }
}
