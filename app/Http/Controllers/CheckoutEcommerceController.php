<?php

namespace App\Http\Controllers;
use App\Services\{ProdutoService, PedidoService,ItemPedidoService, SetupService};
use Illuminate\Support\Facades\Request;
use App\Classes\WonderServices;
use App\Classes\Helper;
use Illuminate\Support\Facades\DB;

class CheckoutEcommerceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function index($id)
    {
        $pedidoService = new PedidoService();
        $setupService = new SetupService();
        $pedido = $pedidoService->find($id);
        $setup = $setupService->find(1);

        $ultimoPedido = $pedidoService->buscaUltimoPedidoNormalProcessado();
        
        //$dataProximaLiberacao = $ultimoPedido->count() > 0? date ('Y-m-d h:i:s',strtotime('+'.$setup->tempo_liberacao_pedido.' days', strtotime($ultimoPedido[0]['data_envio_pedido']))) : date('Y-m-d h:i:s');
        
        /*
        if(strtotime($dataProximaLiberacao) - strtotime(date('Y-m-d H:i:s')) > 0 && $pedido->tipo_pedido_id == 2){
            Helper::setNotify("O Pedido não esta liberado.", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        */
        
        $itemPedidoService = new ItemPedidoService();
        $itens = $itemPedidoService->findBy(
            [
                [
                    'pedido_id','=',$id
                ]
            ]
        );

        return view('ecommerce.checkout.index',
            [
                'itens'  => $itens,
                'pedido' => $pedido
            
            ]
        );
    }


    public function enviarPedido($id)
    {
        $pedidoService = new PedidoService();
        $wonderService = new WonderServices();

        $buscaPedido = $pedidoService->find($id);
        $retorno = $wonderService->enviarPedido($id);
        if(is_numeric($retorno)){
            try{
                DB::transaction(function () use ($pedidoService, $retorno, $buscaPedido) {
                    $pedidoService->update($buscaPedido->id,$buscaPedido->tipo_pedido_id,2,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$buscaPedido->previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$buscaPedido->link_rastreamento,$retorno, date('Y-m-d H:i:s'));
                });
                Helper::setNotify('Pedido '.$buscaPedido->id.' criado com sucesso!', 'success|check-circle');
                
                return redirect()->route('ecommerce.produto');
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
