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
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function index(){
        $pedidoService = new PedidoService();
        $pedidos = $pedidoService->findBy(
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

        $pedidoParaHoje = $this->pedidosParaHoje()->count();

        $pedidoAtrasado = $this->pedidoAtrasado()->count();

        $pedidoComObs   = $this->pedidoComObs()->count();

        return view('admin.pedido.index', compact('pedidos', 'pedidoParaHoje', 'pedidoAtrasado', 'pedidoComObs'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setupService = new SetupService();
        $pedidoService = new PedidoService();
        $itemPedidoService = new ItemPedidoService();

        $setup = $setupService->find(1);
        $pedido = $pedidoService->find($id);
        $itens  = $itemPedidoService->findBy([
            ['pedido_id','=',$id]
        ]);
        
        $obsPedidoService = new ObsPedidoService();
        $observacoes = $obsPedidoService->findBy([
            ['excluido','=',0],
            ['pedido_id','=',$id,'AND']
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

        $statusPedidoService = new StatusPedidoService();
        $buscaStatus = $statusPedidoService->find($_request->ultStatus);
        try {
            DB::transaction(function () use ($id,$status,$link, $buscaStatus,$previsao_entrega,$nova_obs) {

                $pedidoService = new PedidoService();
                $buscaPedido = $pedidoService->find($id);
                $pedidoService->update
                (
                    $id,$buscaPedido->tipo_pedido_id,$status,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$link,$buscaPedido->pedido_terceiro_id
                );
                $obsPedidoService = new ObsPedidoService();
                if($status != $buscaPedido['status_pedido_id']){
                    
                    $obsPedidoService->create($id,"O status do pedido foi alterado para ".$buscaStatus->nome, 0);
                }

                if($nova_obs != ''){
                    $obsPedidoService->create($id,$nova_obs, 0);
                }

            });
            Helper::setNotify('Pedido atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('pedido');
        } catch (\Throwable $th) {
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
                $pedidoService = new PedidoService();
                $buscaPedido = $pedidoService->find($_request->id);
                
                $pedidoService->update($_request->id,$buscaPedido->tipo_pedido_id,6,$buscaPedido->user_id,$buscaPedido->total_pedido,$buscaPedido->numero_itens,$buscaPedido->previsao_entrega,$buscaPedido->acrescimos,$buscaPedido->excluido,$buscaPedido->link_rastreamento,$buscaPedido->pedido_terceiro_id);
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
        $pedidos = $this->pedidoAtrasado();
        $pedidoParaHoje = $this->pedidosParaHoje()->count();
        $pedidoAtrasado = $pedidos->count();
        $pedidoComObs   = $this->pedidoComObs()->count();
        return view('admin.pedido.index', compact('pedidos', 'pedidoParaHoje', 'pedidoAtrasado', 'pedidoComObs'));
    }

    public function entregaHoje()
    {
        $pedidos =$this->pedidosParaHoje();
        $pedidoParaHoje = $this->pedidosParaHoje()->count();
        $pedidoAtrasado = $this->pedidoAtrasado()->count();
        $pedidoComObs   = $this->pedidoComObs()->count();
        return view('admin.pedido.index', compact('pedidos', 'pedidoParaHoje', 'pedidoAtrasado', 'pedidoComObs'));
    }

    public function obsCliente()
    {
        $pedidos =$this->pedidoComObs();
        $pedidoParaHoje = $this->pedidosParaHoje()->count();
        $pedidoAtrasado = $this->pedidoAtrasado()->count();
        $pedidoComObs = $pedidos->count();
        return view('admin.pedido.index', compact('pedidos', 'pedidoParaHoje', 'pedidoAtrasado', 'pedidoComObs'));
    }

    public function pedidosParaHoje()
    {
        $pedidoService = new PedidoService();
        return $pedidoService->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['previsao_entrega','=',date('Y-m-d'),"AND"]
            ]
        );
    }

    public function pedidoAtrasado()
    {
        $pedidoService = new PedidoService();
        return $pedidoService->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['previsao_entrega','<',date('Y-m-d'),"AND"]
            ]
        );
    }

    public function pedidoComObs()
    {
        $pedidoService = new PedidoService();
        $todosPedidos = $pedidoService->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
            ]
        );
        $pedidosComObs = [];
        foreach ($todosPedidos as $key => $value) {
            
            if($value->ultimaObs[0] ?? false){
                if($value->ultimaObs[0]->usuario->perfil->admin_controle_geral == 0 && $value->ultimaObs[0]->usuario->perfil->area_admin == 0) {
                    array_push($pedidosComObs, $value->id);
                }
            }
            
            
        }
        
        $pedidos = $pedidoService->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','<>',1,"AND"],
                ['status_pedido_id','<>',5,"AND"],
                ['status_pedido_id','<>',6,"AND"],
                ['id', '', $pedidosComObs, "IN"]
            ]
        );
        return $pedidos;
    }
}
