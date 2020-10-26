<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Helper;
use App\Services\{GrupoProdutoService};
use Illuminate\Support\Facades\{Validator, DB};

class GrupoProdutoController extends Controller
{
    protected $grupoProdutoService;
    protected $produtoService;

    public function __construct(GrupoProdutoService $grupoProduto)
    {
        $this->middleware('auth');
        $this->grupoProdutoService = $grupoProduto;
    }

    public function index()
    {
        $grupos = $this->grupoProdutoService->findBy(
            [],
            [],
            [['nome','asc']]
        );
        return view('admin.grupoProduto.index',compact('grupos'));
    }

    public function create() {
        return view('admin.grupoProduto.create');
    }
    

    public function store(Request $_request) {        
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        try {
            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->grupoProdutoService->create($create);    
            });
            Helper::setNotify('Novo grupo de produto criado com sucesso!', 'success|check-circle');
            return redirect()->route('grupoProduto');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o grupo de produto", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id) {
        $grupo  = $this->grupoProdutoService->find($_id);
        return view('admin.grupoProduto.update', compact( 'grupo'));
    }


    public function update(Request $request) {
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('id');
        
        $update = self::montaRequest($request);
      
        try {
            DB::transaction(function () use ($update, $id) {
                $this->grupoProdutoService->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Grupo de produto atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('grupoProduto');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o grupo de produto", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    public function ativar_inativar(Request $_request)
    {
        $buscaGrupoProduto = $this->grupoProdutoService->find($_request->id);
        try {
            
            $ativo_inativo      = $buscaGrupoProduto->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaGrupoProduto->inativo == 0 ? 'inativado' : 'ativado';
            
            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->grupoProdutoService->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Grupo de produto '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o grupo de produto ! Verifique se não existe produtos vinculados a esse grupo.", 'danger|close-circle');
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
