<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB};
use Illuminate\Http\Request;
use App\Services\{ProdutoService, GrupoProdutoService};


class ProdutoController extends Controller
{

    protected $produtoService;
    protected $grupoProdutoService;

    public function __construct(ProdutoService $produto, GrupoProdutoService $grupoProduto)
    {
        $this->middleware('auth');
        $this->produtoService = $produto;
        $this->grupoProdutoService = $grupoProduto;
    }

    public function index(){

        $produtos = $this->produtoService->findAll();
        return view('admin.produto.index', compact('produtos'));

    }

    public function create()
    {
        $grupos  = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);
        return view('admin.produto.create', compact('grupos'));
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
                $this->produtoService->create($create);    
            });

            Helper::setNotify('Novo produto criado com sucesso!', 'success|check-circle');
            return redirect()->route('produto');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o produto", 'danger|close-circle');
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
        $produto = $this->produtoService->find($id);
        $grupos  = $this->grupoProdutoService->findBy([
            [
            'inativo','=',0
            ]
        ]);

        return view('admin.produto.update', compact('produto','grupos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $_request)
    {
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        $update = self::montaRequest($_request);
        $id = $_request->get('idProduto');
        try {
            DB::transaction(function () use ($update, $id) {
                $this->produtoService->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Produto atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('produto');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o produto", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Inativa the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ativar_inativar(Request $_request)
    {
        $buscaProduto = $this->produtoService->find($_request->id);
        try {
            $ativo_inativo      = $buscaProduto->inativo == 0 ? 1: 0;
            $nome_ativo_inativo = $buscaProduto->inativo == 0 ? 'inativado' : 'ativado';

            DB::transaction(function () use ($_request) {
                //$this->perfilRepository->update(['inativo' => 1], $_request->id);
            });
            Helper::setNotify('Produto '.$nome_ativo_inativo.' com sucesso!', 'success|check-circle');
            return response()->json(['response' => 'sucesso']);
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar o produto ", 'danger|close-circle');
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
            'id'          => 'required|string',
            'nome'        => 'required|string|min:3',
            'grupo_id'    => 'required|numeric',
            'valor'       => 'required|',
            'qtd_estoque' => 'required|'
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
            'nome'                          => $request->nome,
            'valor'                         => str_replace(',','.',$request->valor),
            'tamanho'                       => '',
            'produto_terceiro_id'           => $request->id,
            'inativo'                       => 0,
            'grupo_produto_id'              => $request->grupo_id,
            'variacao'                      => 0,
            'peso'                          => 0,
            'quantidade_estoque'            => $request->qtd_estoque
        ];
        return $create;
    }
}
