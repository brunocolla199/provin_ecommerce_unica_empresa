<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB, Hash};
use App\Services\{UserService, PerfilService, GrupoService, EmpresaService};

class UsuarioController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index()
    {
        $userService = new UserService();
        $usuarios = $userService->findAll();
        return view('admin.usuario.index', compact('usuarios'));
    }

    public function create() {
        $perfilService = new PerfilService();
        $perfis = $perfilService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $grupoService = new GrupoService();
        $grupos = $grupoService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $empresaService = new EmpresaService();
        $empresas = $empresaService->findBy(
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
                $userService = new UserService();
                $create = self::montaRequest($_request);
                //event(new Registered($create));
                //$this->registered($_request, $create);
                $userService->create($create);    
            });
            Helper::setNotify('Novo usuário criado com sucesso!', 'success|check-circle');
            return redirect()->route('ecommerce.produto');
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao criar o usuário", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id)
    {
        $perfilService = new PerfilService();
        $perfis = $perfilService->findBy(
            [
                ['inativo','=',0]
            ]
        );
        $grupoService = new GrupoService();
        $grupos = $grupoService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $empresaService = new EmpresaService();
        $empresas = $empresaService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $userService = new UserService();
        $usuario = $userService->find($_id);
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
                $userService = new UserService();
                $userService->update(
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
        $userService = new UserService();
        $buscaUsuario = $userService->find($_request->id);
        try {
            $ativo_inativo      = $buscaUsuario->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaUsuario->inativo == 0 ? 'inativado' : 'ativado';

            DB::transaction(function () use ($userService, $_request, $ativo_inativo) {
                $userService->update(['inativo' => $ativo_inativo], $_request->id);
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
                    
                    'email'    => 'required|string|email|max:255|unique:users',
                    'name'     => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'cpf'      => 'required|string|min:14|',
                    'fone'     => 'required|string'
                ]
            );
            
        }else{
            $validator = Validator::make($request->all(), 
                [
                    'name'     => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'cpf'      => 'required|string|min:14|',
                    'fone'     => 'required|string'
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
            $userService = new UserService();
            $buscaSenha = $userService->find($request->get('idUsuario'));
            if($buscaSenha->password == $request->password){
                $senha_igual = true;
            }
        }


        $createUser = [
            'name'                              => $request->name,
            'username'                          => $request->name,
            'email'                             => $request->email,
            'utilizar_permissoes_nivel_usuario' => false,
            'password'                          => $senha_igual == true ? $buscaSenha->password : Hash::make($request->password),
            'administrador'                     => false,
            'perfil_id'                         => $request->perfil ?? null,
            'grupo_id'                          => $request->grupo ?? null,
            'empresa_id'                        => $request->empresa ?? null,
            'cpf_cnpj'                          => $request->cpf ?? null,
            'telefone'                          => $request->fone ?? null
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
