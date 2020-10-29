<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB, Hash};
use App\Services\{UserService, PerfilService, GrupoService, EmpresaService};

class UsuarioController extends Controller
{
    
    protected $userService;
    protected $perfilService;
    protected $grupoService;
    protected $empresaService;


    public function __construct(UserService $user, PerfilService $perfil, GrupoService $grupo, EmpresaService $empresa)
    {
        $this->middleware('auth');
        $this->userService   = $user;
        $this->perfilService = $perfil;
        $this->grupoService  = $grupo;
        $this->empresaService = $empresa;
    }


    public function index()
    {
        $usuarios = $this->userService->findAll(
        );
        return view('admin.usuario.index', compact('usuarios'));
    }

    public function create() {
        $perfis = $this->perfilService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $grupos = $this->grupoService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $empresas = $this->empresaService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        return view('admin.usuario.create', compact('perfis', 'grupos', 'empresas'));
    }

    public function store(Request $_request) 
    {
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        try {
            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                //event(new Registered($create));
                //$this->registered($_request, $create);
                $this->userService->create($create);    
            });
            Helper::setNotify('Novo usuário criado com sucesso!', 'success|check-circle');
            return redirect()->route('usuario');
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao criar o usuário", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id)
    {
        $perfis = $this->perfilService->findBy(
            [
                ['inativo','=',0]
            ]
        );
        $grupos = $this->grupoService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $empresas = $this->empresaService->findBy(
            [
                ['inativo','=',0]
            ]
        );


        $usuario = $this->userService->find($_id);
        return view('admin.usuario.update', compact('usuario', 'perfis', 'grupos', 'empresas'));
    }


    public function update(Request $request)
    {   
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('idUsuario');
        
        $update = self::montaRequest($request);

       
       
        try {
            DB::transaction(function () use ($update, $id) {
                $this->userService->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Usuário atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('usuario');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o usuário", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }
    

    public function ativar_inativar(Request $_request)
    {
        $buscaUsuario = $this->userService->find($_request->id);
        try {
            $ativo_inativo      = $buscaUsuario->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaUsuario->inativo == 0 ? 'inativado' : 'ativado';

            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->userService->update(['inativo' => $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Usuário '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o usuário", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        }
    }

    protected function validator(Request $request)
    {
        if(empty($request->get('idUsuario'))){
            $validator = Validator::make($request->all(),
                [
                    'username' => 'required|string|max:20|unique:users',
                    'email'    => 'required|string|email|max:255|unique:users',
                    'name'     => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'foto'     => 'image|mimes:jpeg,png,jpg',
                    'perfil'   => 'required|numeric',
                    'grupo'    => 'required|numeric'
                ]
            );
            
        }else{
            $validator = Validator::make($request->all(), 
                [
                    'name'     => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'foto'     => 'image|mimes:jpeg,png,jpg',
                    'perfil'   => 'required|numeric',
                    'grupo'    => 'required|numeric'
                ]
            );
        }
    
        if ($validator->fails()) {
            Helper::setNotify($validator->messages()->first(), 'danger|close-circle');
            return false;
        }
        return true;
    }

    

    public function montaRequest(Request $request)
    {
        $senha_igual = false;
        if(!empty($request->get('idUsuario'))){
            $buscaSenha = $this->userService->find($request->get('idUsuario'));
            if($buscaSenha->password == $request->password){
                $senha_igual = true;
            }
        }


        $createUser = [
            'name'                              => $request->name,
            'username'                          => $request->username,
            'email'                             => $request->email,
            'utilizar_permissoes_nivel_usuario' => false,
            'password'                          => $senha_igual == true ? $buscaSenha->password : Hash::make($request->password),
            'administrador'                     => false,
            'perfil_id'                         => $request->perfil,
            'grupo_id'                          => $request->grupo,
            'empresa_id'                        => $request->empresa ?? null
        ];

        if (!empty($request->foto)) {
            $mimeType = $request->foto->getMimeType();
            $imageBase64 = base64_encode(file_get_contents($request->foto->getRealPath()));
            $imageBase64 = 'data:' . $mimeType . ';base64,' . $imageBase64;
            $createUser['foto'] = $imageBase64;
        }

        return $createUser;
    }

}
