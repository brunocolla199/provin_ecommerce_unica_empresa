<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use App\Services\{GrupoService, UserService};

class GrupoController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $grupoService = new GrupoService();
        $grupos = $grupoService->findBy(
            [],
            [],
            [['nome','asc']]
        );
        
        return view('admin.grupo.index', compact('grupos'));
    }


    public function create() {
        return view('admin.grupo.create');
    }


    public function store(Request $_request) 
    {
        try {
            if (!$this->validator($_request)) {
                return redirect()->back()->withInput();
            }
            DB::transaction(function () use ($_request) {
                $grupoService = new GrupoService();
                $grupo = $grupoService->create(
                    [
                    'nome'      => $_request->nome,
                    'descricao' => $_request->descricao,
                    'inativo'   => 0
                    ]
                );
            });
            Helper::setNotify('Novo grupo criado com sucesso!', 'success|check-circle');
            return redirect()->route('grupo');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o grupo", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id) {
        $grupoService = new GrupoService();
        $grupo = $grupoService->find($_id);
        return view('admin.grupo.update', compact('grupo'));
    }


    public function update(Request $_request) {
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        $id = $_request->idGrupo;
        try {
            DB::transaction(function () use ($_request, $id) {
                $grupoService = new GrupoService();
                $grupoService->update(
                    [
                    'nome'      => $_request->nome,
                    'descricao' => $_request->descricao,
                    ]
                    , $id);
            });
            Helper::setNotify('Grupo atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('grupo');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o grupo", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function ativar_inativar(Request $_request)
    {
        $grupoService = new GrupoService();
        $usuarioService = new UserService();
        $buscaGrupo = $grupoService->find($_request->id);
        $usuarios = $usuarioService->findBy(
            [['grupo_id','=',$_request->id]],
            [],
            [],
            [],
            1
        );
        try {
            $ativo_inativo      = $buscaGrupo->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaGrupo->inativo == 0 ? 'inativado' : 'ativado';

            if(!empty($usuarios[0]) && $buscaGrupo->inativo == 0){
                throw new Exception("Existem usu??rios vinculados a esse grupo", 1); 
            }
            DB::transaction(function () use ($grupoService, $_request, $ativo_inativo) {
                $grupoService->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Grupo '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o grupo, verifique se n??o existem usu??rios vinculados a esse grupo", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsevalidator
     */
    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|string|max:100|min:5',
            'descricao' => 'required|string|max:300|min:5'
        ]);

        if ($validator->fails()) {
            Helper::setNotify($validator->messages()->first(), 'danger|close-circle');
            return false;
        }
        return true;
    }

}
