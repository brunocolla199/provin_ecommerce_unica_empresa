<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use App\Repositories\{GrupoRepository, UserRepository};

class GrupoController extends Controller
{
    protected $grupoRepository;
    protected $usuarioRepository;

    public function __construct(GrupoRepository $grupo, UserRepository $user)
    {
        $this->middleware('auth');
        $this->grupoRepository = $grupo;
        $this->usuarioRepository = $user;
    }
    
    public function index() {
        $grupos = $this->grupoRepository->findBy(
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
                $grupo = $this->grupoRepository->create(
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
        $grupo = $this->grupoRepository->find($_id);
        return view('admin.grupo.update', compact('grupo'));
    }


    public function update(Request $_request) {
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        $id = $_request->idGrupo;
        try {
            DB::transaction(function () use ($_request, $id) {
                $this->grupoRepository->update(
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


    public function ativarInativar(Request $_request)
    {
        $buscaGrupo = $this->grupoRepository->find($_request->id);
        $usuarios = $this->usuarioRepository->findBy(
            [['grupo_produto_id','=',$_request->id]],
            [],
            [],
            [],
            1
        );
        try {
            $ativo_inativo      = $buscaGrupo->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaGrupo->inativo == 0 ? 'inativado' : 'ativado';

            if(!empty($usuarios[0]) && $buscaGrupo->inativo == 0){
                throw new Exception("Existem usuários vinculados a esse grupo", 1); 
            }
            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->grupoRepository->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Grupo '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o grupo, verifique se não existem usuários vinculados a esse grupo", 'danger|close-circle');
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
