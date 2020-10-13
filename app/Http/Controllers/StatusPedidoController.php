<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use App\Repositories\{StatusPedidoRepository, PedidoRepository};
use Illuminate\Support\Facades\{Validator, DB};

class StatusPedidoController extends Controller
{
    protected $statusPedidoRepository;
    protected $pedidoRepository;

    public function __construct(StatusPedidoRepository $statusPedido, PedidoRepository $pedido)
    {
        $this->middleware('auth');
        $this->statusPedidoRepository = $statusPedido;
        $this->pedidoRepository = $pedido;
    }

    public function index()
    {
        $status = $this->statusPedidoRepository->findBy(
            [],
            [],
            [['nome','asc']]
        );
        return view('admin.statusPedido.index',compact('status'));
    }

    public function create() {
        return view('admin.statusPedido.create');
    }
    

    public function store(Request $_request) {        
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        try {
            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->statusPedidoRepository->create($create);    
            });
            Helper::setNotify('Novo status do pedido criado com sucesso!', 'success|check-circle');
            return redirect()->route('statusPedido');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o status do pedido", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id) {
        $statusPedido = $this->statusPedidoRepository->find($_id);
        return view('admin.statusPedido.update', compact( 'statusPedido'));
    }


    public function update(Request $request) {
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('id');
        
        $update = self::montaRequest($request);
      
        try {
            DB::transaction(function () use ($update, $id) {
                $this->statusPedidoRepository->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Status do pedido atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('statusPedido');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o status do pedido", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    public function ativar_inativar(Request $_request)
    {
        $buscaStatusPedido = $this->statusPedidoRepository->find($_request->id);
        try {
            $ativo_inativo      = $buscaStatusPedido->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaStatusPedido->inativo == 0 ? 'inativado' : 'ativado';
            
            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->statusPedidoRepository->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Status do pedido '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o status do pedido ! Verifique se não existe pedido vinculados a esse status.", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        }
    }

    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'          => 'required|string|max:50|min:3',
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
            'nome'                           => $request->nome,
            'inativo'                        => 0,
        ];


        return $create;
    }
}
