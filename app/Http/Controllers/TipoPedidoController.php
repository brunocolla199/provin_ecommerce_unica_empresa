<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use App\Services\TipoPedidoService;

class TipoPedidoController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tipoPedidoService = new TipoPedidoService();
        $tipos = $tipoPedidoService->findBy(
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
                $tipoPedidoService = new TipoPedidoService();
                $tipoPedidoService->create($create);    
            });
            Helper::setNotify('Novo tipo de pedido criado com sucesso!', 'success|check-circle');
            return redirect()->route('tipoPedido');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o tipo de pedido", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id) {
        $tipoPedidoService = new TipoPedidoService();
        $tipoPedido = $tipoPedidoService->find($_id);
        return view('admin.tipoPedido.update', compact( 'tipoPedido'));
    }


    public function update(Request $request) {
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('id');
        
        $update = self::montaRequest($request);
        unset($update['inativo']);
        try {
            DB::transaction(function () use ($update, $id) {
                $tipoPedidoService = new TipoPedidoService();
                $tipoPedidoService->update(
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
        $tipoPedidoService = new TipoPedidoService();
        $buscaTipoPedido = $tipoPedidoService->find($_request->id);
        try {
            
            $ativo_inativo      = $buscaTipoPedido->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaTipoPedido->inativo == 0 ? 'inativado' : 'ativado';
        
            DB::transaction(function () use ($tipoPedidoService, $_request, $ativo_inativo) {
                $tipoPedidoService->update(['inativo' => $ativo_inativo], $_request->id);
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
