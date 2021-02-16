<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB, Auth};
use Illuminate\Http\Request;

use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\ObsPedidoService;
use App\Services\StatusPedidoService;
use App\Services\SetupService;
use App\Services\UserService;

class PedidoEcommerceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $userService = new UserService();
        $pedidoService = new PedidoService();

        $usuariosIn = $userService->buscaUsuariosMesmaEmpresa();
        
        $pedidos = $pedidoService->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','!=',1,"AND"],
                ['user_id','',$usuariosIn,"IN"]
            ],[],
            [
                ['updated_at','desc']
            ]
        );

        return view('ecommerce.pedido.index', [
            'pedidos' => $pedidos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detalhe($id)
    {
        $pedidoService = new PedidoService();
        $itemPedidoService = new ItemPedidoService();
        $obsPedidoService = new ObsPedidoService();
        $setupService = new SetupService();

        $pedido = $pedidoService->find($id);
        $itens  = $itemPedidoService->findBy([
            ['pedido_id','=',$id]
        ]);

        $observacoes = $obsPedidoService->findBy([
            ['excluido','=',0],
            ['pedido_id','=',$id,'AND']
        ]);

        $setup = $setupService->find(1);
        return view('ecommerce.detalhePedido.index',
            [
                'pedido' => $pedido,
                'itens' => $itens,
                'observacoes' => $observacoes,
                'caminho_imagem' => $setup['caminho_imagen_produto']
            ]
        );
    }

   /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsevalidator
     */
    public function validator(Request $_request)
    {
        $validator = Validator::make($_request->all(), [
            'id'          => 'required|string'
        ]);

        if ($validator->fails()) {
            Helper::setNotify($validator->messages()->first(), 'danger|close-circle');
            return false;
        }
        return true;
    }

    public function montaRequest(Request $request)
    {
        $create = [
            'link_rastreamento'  => $request->link,
            'status_pedido_id'   => $request->ultStatus
        ];
        return $create;
    }

    public function novaObs(Request $request)
    {
        $idPedido = $request->idPedido;
        $obs      = $request->nova_obs;
        
        try {
            DB::transaction(function () use ($idPedido,$obs) {

            $obsPedidoService = new ObsPedidoService();
            $obsPedidoService->create($idPedido,$obs,0);
            });
            Helper::setNotify('Nova observação salva com sucesso!', 'success|check-circle');
            return redirect()->route('ecommerce.pedido.detalhe', ['id' => $idPedido ]);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao salvar nova observação", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }
}
