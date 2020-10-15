<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB, Auth};
use Illuminate\Http\Request;

use App\Repositories\PedidoRepository;
use App\Repositories\ItemPedidoRepository;
use App\Repositories\ObsPedidoRepository;
use App\Repositories\StatusPedidoRepository;

class PedidoController extends Controller
{
    protected $pedidoRepository;

    protected $itemPedidoRepository;
    protected $produtoRepository;
    protected $observacoesRepository;
    protected $statusPedidoRepository;

    public function __construct(PedidoRepository $pedido, ItemPedidoRepository $itemPedido, ObsPedidoRepository $obsPedido, StatusPedidoRepository $statusPedido)
    {
        $this->middleware('auth');
        $this->pedidoRepository = $pedido;
        $this->itemPedidoRepository = $itemPedido;
        $this->observacoesRepository = $obsPedido;
        $this->statusPedidoRepository = $statusPedido;
    }

    public function index(){

        $pedidos = $this->pedidoRepository->findBy([
            [
            'excluido','=',0
            ]
        ]);
        return view('admin.pedido.index', compact('pedidos'));

    }

    /*
    public function create()
    {
        $grupos  = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
        return view('admin.pedido.create', compact('grupos'));
    }
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(Request $_request)
    {
        try {
            if (!$this->validator($_request)) {
                return redirect()->back()->withInput();
            }

            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->produtoRepository->create($create);    
            });

            Helper::setNotify('Novo produto criado com sucesso!', 'success|check-circle');
            return redirect()->route('produto');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o produto", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        return view('admin.pedido.update', compact('pedido','itens','observacoes'));
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
        $update = self::montaRequest($_request);
        $id = $_request->get('idPedido');
        $buscaStatus = $this->statusPedidoRepository->find($_request->ultStatus);
        try {
            DB::transaction(function () use ($update, $id, $buscaStatus) {
                

                $this->pedidoRepository->update
                (
                    $update,
                    $id
                );

                $createObs = new ObsPedido();
                $array = $createObs->montaRequestObs($id,"O status do pedido foi alterado para ".$buscaStatus->nome,'0');
                
                $this->observacoesRepository->create($array);


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
                $this->pedidoRepository->update(['status_id' => 6], $_request->id);
            });
            Helper::setNotify('Pedido cancelado com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao cancelar o pedido ", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        } 
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
