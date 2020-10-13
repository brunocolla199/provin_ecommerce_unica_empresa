<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use App\Repositories\TipoPedidoRepository;
use Illuminate\Support\Facades\{Validator, DB};
use App\Repositories\PedidoRepository;

class TipoPedidoController extends Controller
{
    protected $tipoPedidoRepository;
    protected $pedidoRepository;

    public function __construct(TipoPedidoRepository $tipoPedido, PedidoRepository $pedido)
    {
        $this->middleware('auth');
        $this->tipoPedidoRepository = $tipoPedido;
        $this->pedidoRepository = $pedido;
    }

    public function index()
    {
        $tipos = $this->tipoPedidoRepository->findBy(
            [],
            [],
            [['nome','asc']]
        );
        return view('admin.tipoPedido.index',compact('tipos'));
    }

    public function create() {
        return view('admin.tipoPedido.create');
    }
    

    public function store(Request $_request) {        
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        try {
            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->tipoPedidoRepository->create($create);    
            });
            Helper::setNotify('Novo tipo de pedido criado com sucesso!', 'success|check-circle');
            return redirect()->route('tipoPedido');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o tipo de pedido", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id) {
        $tipoPedido = $this->tipoPedidoRepository->find($_id);
        return view('admin.tipoPedido.update', compact( 'tipoPedido'));
    }


    public function update(Request $request) {
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('id');
        
        $update = self::montaRequest($request);
      
        try {
            DB::transaction(function () use ($update, $id) {
                $this->tipoPedidoRepository->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Tipo de pedido atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('tipoPedido');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o tipo de pedido", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    public function ativar_inativar(Request $_request)
    {
        $buscaTipoPedido = $this->tipoPedidoRepository->find($_request->id);
        try {
            
            $ativo_inativo      = $buscaTipoPedido->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaTipoPedido->inativo == 0 ? 'inativado' : 'ativado';
        
            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->tipoPedidoRepository->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Tipo de pedido '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualiza o tipo de pedido ! Verifique se não existe pedido vinculados a esse tipo.", 'danger|close-circle');
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
