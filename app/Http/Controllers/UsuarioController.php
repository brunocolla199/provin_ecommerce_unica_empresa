<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\{UserRepository, PerfilRepository, GrupoRepository, EmpresaRepository};

class UsuarioController extends Controller
{
    
    protected $userRepository;
    protected $perfilRepository;
    protected $grupoRepository;
    protected $empresaRepository;


    public function __construct(UserRepository $user, PerfilRepository $perfil, GrupoRepository $grupo, EmpresaRepository $empresa)
    {
        $this->middleware('auth');
        $this->userRepository   = $user;
        $this->perfilRepository = $perfil;
        $this->grupoRepository  = $grupo;
        $this->empresaRepository = $empresa;
    }


    public function index()
    {
        $usuarios = $this->userRepository->findAll(
        );
        return view('admin.usuario.index', compact('usuarios'));
    }

    public function create() {
        $perfis = $this->perfilRepository->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $grupos = $this->grupoRepository->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $empresas = $this->empresaRepository->findBy(
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
                $this->userRepository->create($create);    
            });
            Helper::setNotify('Novo usuário criado com sucesso!', 'success|check-circle');
            return redirect()->route('usuario');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o usuário", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id)
    {
        $perfis = $this->perfilRepository->findBy(
            [
                ['inativo','=',0]
            ]
        );
        $grupos = $this->grupoRepository->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $empresas = $this->empresaRepository->findBy(
            [
                ['inativo','=',0]
            ]
        );


        $usuario = $this->userRepository->find($_id);
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
                $this->userRepository->update(
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
    

    public function ativarInativar(Request $_request)
    {
        $buscaUsuario = $this->perfilRepository->find($_request->id);
        try {
            $ativo_inativo      = $buscaUsuario->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaUsuario->inativo == 0 ? 'inativado' : 'ativado';
            
            DB::transaction(function () use ($_request, $ativo_inativo) {
                $this->userRepository->update(['inativo' => $ativo_inativo], $_request->id);
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
        
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'foto'     => 'image|mimes:jpeg,png,jpg',
            'perfil'   => 'required|numeric',
            'grupo'    => 'required|numeric'
        ]);

        if(empty($request->get('idUsuario'))){
            $validator['username'] = 'required|string|max:20|unique:users';
            $validator['email'] = 'required|string|email|max:255|unique:users';
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
            $buscaSenha = $this->userRepository->find($request->get('idUsuario'));
            if($buscaSenha->password == $request->password){
                $senha_igual = true;
            }
        }


        $createUser = [
            'name'                              => $request->name,
            'username'                          => $request->username,
            'email'                             => $request->email,
            'utilizar_permissoes_nivel_usuario' => false,
            'password'                          => $senha_igual == true ? $buscaSenha->password : crypt($request->password),
            'administrador'                     => false,
            'perfil_id'                         => $request->perfil,
            'grupo_produto_id'                  => $request->grupo,
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
