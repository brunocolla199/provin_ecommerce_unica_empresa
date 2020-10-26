<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use App\Services\{PerfilService, UserService};

class PerfilController extends Controller
{
    protected $perfilService;
    protected $usuarioService;

    public function __construct(PerfilService $perfil, UserService $user)
    {
        $this->middleware('auth');
        $this->perfilService = $perfil;
        $this->usuarioService = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfis = $this->perfilService->findAll();
       
        return view('admin.perfil.index', compact('perfis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.perfil.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $_request)
    {
        try {
            if (!$this->validator($_request)) {
                return redirect()->back()->withInput();
            }

            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->perfilService->create($create); 
            });

            Helper::setNotify('Novo perfil criado com sucesso!', 'success|check-circle');
            return redirect()->route('perfil');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o perfil", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perfil = $this->perfilService->find($id);
        return view('admin.perfil.update', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $_request, $id)
    {
        if (!$this->validator($_request, $id)) {
            return redirect()->back()->withInput();
        }

        $update = self::montaRequest($_request);
        try {
            DB::transaction(function () use ($update, $id) {
                $this->perfilService->update($update, $id);
            });
            Helper::setNotify('Perfil atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('perfil');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o perfil", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Inativa the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ativarInativar(Request $_request)
    {
        $buscaPerfil = $this->perfilService->find($_request->id);
        $usuarios = $this->usuarioService->findBy(
            [['perfil_id','=',$_request->id]],
            [],
            [],
            [],
            1
        );

        try {
            $ativo_inativo      = $buscaPerfil->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaPerfil->inativo == 0 ? 'inativado' : 'ativado';
            
            if(!empty($usuarios[0]) && $buscaPerfil->inativo == 0){
                throw new Exception("Error Processing Request", 1);
            }
            
            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->perfilService->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Perfil '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o perfil.", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        } 
    }

   /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsevalidator
     */
    public function validator(Request $_request, $id = "")
    {
        $validator = Validator::make($_request->all(), [
            'nome' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            Helper::setNotify($validator->messages()->first(), 'danger|close-circle');
            return false;
        }
        return true;
    }

    public function montaRequest(Request $request)
    {
        
        return [
            'nome'                       => $request->nome,
            'inativo'                    => 0,
            'observacao'                 => $request->obs,
            'eco_listar_pedido'          => $request->eco_listar_pedido == 'on' ? 1 :0,
            'eco_detalhes_pedido'        => $request->eco_detalhes_pedido == 'on' ? 1 :0,
            'eco_enviar_pedido_normal'   => $request->eco_enviar_pedido_normal == 'on' ? 1 :0,
            'eco_enviar_pedido_expresso' => $request->eco_enviar_pedido_expresso == 'on' ? 1 :0,
            'admin_controle_geral'       => $request->admin_controle_geral == 'on' ? 1 :0,
            'area_admin'                 => $request->area_admin == 'on' ? 1 :0,
        ];
    }
}
