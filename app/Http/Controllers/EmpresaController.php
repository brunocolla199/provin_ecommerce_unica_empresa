<?php

namespace App\Http\Controllers;

use App\Classes\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use App\Repositories\{EmpresaRepository, CidadeRepository, PedidoRepository};

class EmpresaController extends Controller
{

    protected $empresaRepository ;
    protected $cidadeRepository;
    protected $pedidoRepository;
    

    /*
    * Construtor
    */
    public function __construct(EmpresaRepository $empresa, CidadeRepository $cidade, PedidoRepository $pedido)
    {
        $this->middleware('auth');
        $this->empresaRepository = $empresa;
        $this->cidadeRepository = $cidade;
        $this->pedidoRepository = $pedido;
    }
    
    public function index() {
        $empresas = $this->empresaRepository->findBy(
            [],
            [],
            [['nome_fantasia','asc']]
        );
        return view('admin.empresa.index', compact('empresas'));
    }
    

    public function create() {
        $cidades = $this->cidadeRepository->findAll();
        return view('admin.empresa.create', compact('cidades'));
    }
    

    public function store(Request $_request) {        
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        try {
            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->empresaRepository->create($create);    
            });
            Helper::setNotify('Nova empresa criada com sucesso!', 'success|check-circle');
            return redirect()->route('empresa');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar a empresa", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id) {
        $cidades = $this->cidadeRepository->findAll();
        $empresa = $this->empresaRepository->find($_id);
        return view('admin.empresa.update', compact('cidades', 'empresa'));
    }


    public function update(Request $request) {
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('idEmpresa');
        
        $update = self::montaRequest($request);
      
        try {
            DB::transaction(function () use ($update, $id) {
                $this->empresaRepository->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Empresa atualizada com sucesso!', 'success|check-circle');
            return redirect()->route('empresa');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar a empresa", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    public function ativar_inativar(Request $_request)
    {
        $buscaEmpresa = $this->empresaRepository->find($_request->id);
        try {
            $ativo_inativo      = $buscaEmpresa->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaEmpresa->inativo == 0 ? 'inativado' : 'ativado';
            DB::transaction(function () use ($_request,  $ativo_inativo) {
                $this->empresaRepository->update(['inativo' =>  $ativo_inativo], $_request->id);
            });
            Helper::setNotify('Empresa '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar a empresa.", 'danger|close-circle');
            return response()->json(['response' => 'erro']);
        }
    }

    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razao_social'          => 'required|string|max:50',
            'nome_fantasia'         => 'required|string|max:50',
            'tipo_pessoa'           => 'required|string|min:1|max:1',
            'telefone'              => 'required|string|min:14|max:15',
            'email'                 => 'required|string|max:50',
            'cep'                   => 'required|string|max:10',
            'numero'                => 'required',
            'bairro'                => 'required',
            'endereco'              => 'required|string|max:50',
            'cidade_id'             => 'required|numeric'
        ]);

        if($request->tipo_pessoa == 'F'){
            $validator['cpf']  = 'required|string|max:15|min:15';
        }else{
            $validator['cnpj']  = 'required|string|max:19|min:19';
        }

        if ($validator->fails()) {
            Helper::setNotify($validator->messages()->first(), 'danger|close-circle');
            return false;
        }
        return true;
    }

    public function montaRequest(Request $request)
    {
        $create = [
            'razao_social'                           => $request->razao_social,
            'nome_fantasia'                          => $request->nome_fantasia,
            'cpf_cnpj'                               => $request->cpf ?? $request->cnpj,
            'telefone'                               => $request->telefone,
            'cidade_id'                              => $request->cidade_id,
            'tipo_pessoa'                            => $request->tipo_pessoa,
            'empresa_terceiro_id'                    => $request->empresa_terceiro,
            'endereco'                               => $request->endereco,
            'numero'                                 => $request->numero,
            'complemento'                            => $request->complemento,
            'cep'                                    => $request->cep,
            'bairro'                                 => $request->bairro,
            'inativo'                                => $request->inativo ?? 0,
            'email'                                  => $request->email
        ];


        return $create;
    }


    

}