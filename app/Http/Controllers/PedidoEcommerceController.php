<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB, Auth};
use Illuminate\Http\Request;

use App\Services\GrupoProdutoService;
use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\ObsPedidoService;
use App\Services\StatusPedidoService;

class PedidoEcommerceController extends Controller
{
    protected $pedidoService;

    protected $itemPedidoService;
    protected $produtoService;
    protected $obsPedidoService;
    protected $statusPedidoService;
    protected $grupoProdutoService;
    private $grupos;

    public function __construct(PedidoService $pedido, ItemPedidoService $itemPedido, ObsPedidoService $obsPedido, StatusPedidoService $statusPedido, GrupoProdutoService $grupoProdutoService)
    {
        $this->middleware('auth');
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $itemPedido;
        $this->obsPedidoService = $obsPedido;
        $this->statusPedidoService = $statusPedido;
        $this->grupoProdutoService = $grupoProdutoService;

        $this->grupos = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);
    }

    public function index(){

        $pedidos = $this->pedidoService->findBy(
            [
                [
                'excluido','=',0
                ]
            ],[],
            [
                [
                    'updated_at','desc'
                ]
            ]
        );

        return view('ecommerce.pedido.index', [
            'grupos'=> $this->grupos,
            'pedidos' => $pedidos
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
            ]
        ]);

        return view('ecommerce.detalhePedido.index',
            [
                'pedido' => $pedido,
                'itens' => $itens,
                'observacoes' => $observacoes,
                'grupos'=> $this->grupos
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

    
}
