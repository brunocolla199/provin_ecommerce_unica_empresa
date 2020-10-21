<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Repositories\GrupoProdutoRepository;
use Illuminate\Support\Facades\{Validator, DB, Auth};
use Illuminate\Http\Request;

use App\Repositories\PedidoRepository;
use App\Repositories\ItemPedidoRepository;
use App\Repositories\ObsPedidoRepository;
use App\Repositories\StatusPedidoRepository;

class PedidoEcommerceController extends Controller
{
    protected $pedidoRepository;

    protected $itemPedidoRepository;
    protected $produtoRepository;
    protected $observacoesRepository;
    protected $statusPedidoRepository;
    protected $grupoProdutoRepository;
    private $grupos;

    public function __construct(PedidoRepository $pedido, ItemPedidoRepository $itemPedido, ObsPedidoRepository $obsPedido, StatusPedidoRepository $statusPedido, GrupoProdutoRepository $grupoProdutoRepository)
    {
        $this->middleware('auth');
        $this->pedidoRepository = $pedido;
        $this->itemPedidoRepository = $itemPedido;
        $this->observacoesRepository = $obsPedido;
        $this->statusPedidoRepository = $statusPedido;
        $this->grupoProdutoRepository = $grupoProdutoRepository;

        $this->grupos = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
    }

    public function index(){

        $pedidos = $this->pedidoRepository->findBy(
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
        $pedido = $this->pedidoRepository->find($id);
        $itens  = $this->itemPedidoRepository->findBy([
            [
            'pedido_id','=',$id
            ]
        ]);

        $observacoes = $this->observacoesRepository->findBy([
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
