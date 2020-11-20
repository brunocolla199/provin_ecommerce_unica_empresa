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
    protected $pedidoService;

    protected $itemPedidoService;
    protected $produtoService;
    protected $obsPedidoService;
    protected $statusPedidoService;
    protected $setupService;
    protected $userService;


    public function __construct(UserService $userService, PedidoService $pedido, ItemPedidoService $itemPedido, ObsPedidoService $obsPedido, StatusPedidoService $statusPedido, SetupService $setup)
    {
        $this->middleware('auth');
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $itemPedido;
        $this->obsPedidoService = $obsPedido;
        $this->statusPedidoService = $statusPedido;
        $this->setupService = $setup;
        $this->userService = $userService;
    
    }

    public function index(){

        $usuariosIn = $this->userService->buscaUsuariosMesmaEmpresa();
        
        $pedidos = $this->pedidoService->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','!=',1,"AND"],
                ['user_id','',$usuariosIn,"IN"]
            ],[],
            [
                [
                    'updated_at','desc'
                ]
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
            ['pedido_id','=',$id,'AND']
        ]);

        $setup = $this->setupService->find(1);



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
            $this->obsPedidoService->create($idPedido,$obs,0);
            });
            Helper::setNotify('Nova observação salva com sucesso!', 'success|check-circle');
            return redirect()->route('ecommerce.pedido.detalhe', ['id' => $idPedido ]);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao salvar nova observação", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }

    
}
