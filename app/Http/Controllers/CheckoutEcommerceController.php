<?php

namespace App\Http\Controllers;
use App\Services\{ProdutoService, PedidoService,ItemPedidoService };
use Illuminate\Support\Facades\Request;
use App\Classes\WonderServices;
use App\Classes\Helper;

class CheckoutEcommerceController extends Controller
{
    protected $produtoService;
    protected $pedidoService;
    protected $itemPedidoService;
    protected $wonderService;

    public $grupos;


    public function __construct( ProdutoService $produto,PedidoService $pedido,ItemPedidoService $item, WonderServices $wonder)
    {
        $this->middleware('auth');
       
        $this->produtoService = $produto;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->wonderService = $wonder;

        
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

        return view('ecommerce.checkout.index',
            [
                'itens'  => $itens
            
            ]
        );
    }


    public function enviarPedido($id)
    {
        $buscaPedido = $this->pedidoService->find($id);
        $retorno = $this->wonderService->enviarPedido($id);

        if(is_numeric($retorno)){
            try{
                DB::transaction(function () use ($retorno, $buscaPedido) {
                    $this->pedidoService->update($buscaPedido->id,$buscaPedido->tipo_pedido_id,$buscaPedido->status_pedido_id,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$buscaPedido->previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$buscaPedido->link_rastreamento,$retorno);
                    Helper::setNotify('Pedido '.$retorno.' criado com sucesso!', 'success|check-circle');
                    redirect()->route('ecommerce.produto');
                });
            } catch (\Throwable $th) {
                Helper::setNotify("Erro ao salvar o pedido", 'danger|close-circle');
                return redirect()->back()->withInput();
            }
           
        }else{
            Helper::setNotify($retorno, 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }
}
