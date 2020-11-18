<?php

namespace App\Http\Controllers;
use App\Services\{ProdutoService, PedidoService,ItemPedidoService, SetupService};
use Illuminate\Support\Facades\Request;
use App\Classes\WonderServices;
use App\Classes\Helper;
use Illuminate\Support\Facades\DB;

class CheckoutEcommerceController extends Controller
{
    protected $produtoService;
    protected $pedidoService;
    protected $itemPedidoService;
    protected $wonderService;
    protected $setupService;

    public $grupos;


    public function __construct( ProdutoService $produto,PedidoService $pedido,ItemPedidoService $item, SetupService $setup,WonderServices $wonder)
    {
        $this->middleware('auth');
       
        $this->produtoService = $produto;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->wonderService = $wonder;
        $this->setupService = $setup;
        
    }

    public function index($id)
    {
        $pedido = $this->pedidoService->find($id);
        $setup = $this->setupService->find(1);

        $ultimoPedido = $this->pedidoService->buscaUltimoPedidoNormalProcessado();
        
        $dataProximaLiberacao = $ultimoPedido->count() > 0? date ('Y-m-d h:i:s',strtotime('+'.$setup->tempo_liberacao_pedido.' days', strtotime($ultimoPedido[0]['data_envio_pedido']))) : date('Y-m-d h:i:s');
        
        if(strtotime($dataProximaLiberacao) - strtotime(date('Y-m-d H:i:s')) > 0 && $pedido->tipo_pedido_id == 2){
            Helper::setNotify("O Pedido não esta liberado.", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
        
        $itens = $this->itemPedidoService->findBy(
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
        $buscaPedido = $this->pedidoService->find($id);
        $retorno = $this->wonderService->enviarPedido($id);
        if(is_numeric($retorno)){
            try{
                DB::transaction(function () use ($retorno, $buscaPedido) {
                    $this->pedidoService->update($buscaPedido->id,$buscaPedido->tipo_pedido_id,2,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$buscaPedido->previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$buscaPedido->link_rastreamento,$retorno, date('Y-m-d H:i:s'));
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
