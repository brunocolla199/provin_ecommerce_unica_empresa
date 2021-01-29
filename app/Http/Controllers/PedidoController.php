<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Request;

use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\StatusPedidoService;
use App\Services\ObsPedidoService;
use App\Services\SetupService;

class PedidoController extends Controller
{
    protected $pedidoService;

    protected $itemPedidoService;
    protected $produtoService;
    protected $statusPedidoService;
    protected $obsPedidoService;
    protected $setupService;

    public function __construct(PedidoService $pedido, ItemPedidoService $itemPedido, StatusPedidoService $statusPedido, ObsPedidoService $obsPedidoServico, SetupService $setup)
    {
        $this->middleware('auth');
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $itemPedido;
        $this->statusPedidoService = $statusPedido;
        $this->obsPedidoService = $obsPedidoServico;
        $this->setupService   = $setup;
    }

    public function index(){

        $pedidos = $this->pedidoService->findBy(
        [
            [
            'excluido','=',0
            ],
            ['status_pedido_id','<>',1,"AND"]
        ],[],
        [
            ['id','desc']
        ]
        );

        $pedidoParaHoje = $this->pedidoService->findBy(
            [
                [
                    'excluido','=',0
                ],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['previsao_entrega','=',date('Y-m-d'),"AND"]
            ]
        )->count();

        $pedidoAtrasado = $this->pedidoService->findBy(
            [
                [
                    'excluido','=',0
                ],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['previsao_entrega','<',date('Y-m-d'),"AND"]
            ]
        )->count();

        return view('admin.pedido.index', compact('pedidos', 'pedidoParaHoje', 'pedidoAtrasado'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setup = $this->setupService->find(1);
        $pedido = $this->pedidoService->find($id);
        $itens  = $this->itemPedidoService->findBy([
            [
            'pedido_id','=',$id
            ]
        ]);

        $observacoes = $this->obsPedidoService->findBy([
            [
            'excluido','=',0
            ],
            [
            'pedido_id','=',$id,'AND'
            ]
        ]);   
        $caminho_imagem = $setup->caminho_imagen_produto;   
        return view('admin.pedido.update', compact('pedido','itens','observacoes', 'caminho_imagem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $_request)
    {
        $link = $_request->link;
        $status= $_request->ultStatus;
        $id = $_request->get('idPedido');
        $previsao_entrega = $_request->get('previsao_entrega') ? date('Y-m-d',strtotime($_request->get('previsao_entrega'))) : null;
        $nova_obs = $_request->nova_obs ? $_request->nova_obs : '';

        $buscaStatus = $this->statusPedidoService->find($_request->ultStatus);
        try {
            DB::transaction(function () use ($id,$status,$link, $buscaStatus,$previsao_entrega,$nova_obs) {
                $buscaPedido = $this->pedidoService->find($id);
                $this->pedidoService->update
                (
                    $id,$buscaPedido->tipo_pedido_id,$status,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$link,$buscaPedido->pedido_terceiro_id
                );
                if($status != $buscaPedido['status_pedido_id']){
                    $this->obsPedidoService->create($id,"O status do pedido foi alterado para ".$buscaStatus->nome, 0);
                }

                if($nova_obs != ''){
                    $this->obsPedidoService->create($id,$nova_obs, 0);
                }

            });
            Helper::setNotify('Pedido atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('pedido');
        } catch (\Throwable $th) {
            var_dump($th);
            Helper::setNotify("Erro ao atualizar o pedido", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Inativa the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelar(Request $_request)
    {
        try {
            
            DB::transaction(function () use ($_request) {
                $buscaPedido = $this->pedidoService->find($_request->id);
                $this->pedidoService->update($_request->id,$buscaPedido->tipo_pedido_id,6,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$buscaPedido->previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$buscaPedido->link_rastreamento,$buscaPedido->pedido_terceiro_id);
            });
            Helper::setNotify('Pedido cancelado com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao cancelar o pedido ", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        } 
    }

    public function entregaAtrasada()
    {
        $pedidos = $this->pedidoService->findBy(
            [
                [
                    'excluido','=',0
                ],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['previsao_entrega','<',date('Y-m-d'),"AND"]
            ]
        );
    
        $pedidoParaHoje = $this->pedidoService->findBy(
            [
                [
                    'excluido','=',0
                ],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['previsao_entrega','=',date('Y-m-d'),"AND"]
            ]
        )->count();
    
        $pedidoAtrasado = $pedidos->count();
        return view('admin.pedido.index', compact('pedidos', 'pedidoParaHoje', 'pedidoAtrasado'));
    }
   

}
