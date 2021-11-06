<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SetupService;
use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB};
use function GuzzleHttp\json_encode;
use App\Services\GrupoProdutoService;
use App\Services\ProdutoService;
use App\Services\EmpresaService;
use App\Classes\WonderServices;
use App\Services\EstoqueService;
use App\Services\PerfilService;
use App\Services\GrupoService;
use App\Models\Empresa;

class ConfiguracaoController extends Controller
{

    protected $empresaService;
    protected $estoqueService;
    protected $wonderService;

    public function __construct()
    {
        //$this->middleware('auth');
        set_time_limit(10000000);

        $this->empresaService = new EmpresaService();
        $this->estoqueService = new EstoqueService();
        $this->wonderService = new WonderServices();
    }

    public function index()
    {
        $setupService = new SetupService();
        $grupoService = new GrupoProdutoService();
        $perfilService = new PerfilService();
        $grupoUsuarioService = new GrupoService();
        $empresaService = new EmpresaService();

        $configuracao = $setupService->findAll()->first();
        $tamanhos     = [4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34];
        $grupos       = $grupoService->findBy(
            [
                ['inativo','=',0]
            ]
        );

        $perfils = $perfilService->findBy(
            [
                ['inativo', '=', 0]
            ]
        );

        $gruposUsuarios = $grupoUsuarioService->findBy(
            [
                ['inativo', '=', 0]
            ]
        );

        $empresas = $empresaService->findBy(
            [
                ['inativo', '=', 0]
            ]
        );
        
        return view('admin.configuracao.index', compact('configuracao','tamanhos','grupos', 'perfils', 'gruposUsuarios', 'empresas'));
    }

    public function update(Request $_request)
    {
        if (!$this->validator($_request)) {
            return redirect()->back()->withInput();
        }
        $id = $_request->id;
        $update = self::montaRequest($_request);
        try {
            DB::transaction(function () use ($update, $id) {
                $setupService = new SetupService();
                $setupService->update(
                    $update
                    , $id);
            });
            Helper::setNotify('Configurações atualizadas com sucesso!', 'success|check-circle');
            return redirect()->route('configuracao');
        } catch (\Throwable $th) {
            
            Helper::setNotify("Erro ao atualizar as configurações", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prazo'                       => 'required|max:100|min:1',
            'valor_add'                    => 'required|min:0',
            'caminho_imagens_produtos'    => 'required|string',
            'caminho_importacao_produtos' => 'required|string',
            'logo_login'                  => 'image|mimes:jpeg,png,jpg',
            'logo_sistema'                => 'image|mimes:jpeg,png,jpg',
            'link_sistema_terceiros'      => 'required|string',
            'usuario_sistema_terceiros'    => 'required|string',
            'senha_sistema_terceiros'      => 'required|string',
            'telefone_proprietaria'        => 'required|string',
            'email_proprietaria'           => 'required|email:rfc,dns',
            'empresa_default_sistema_terceiros' => 'required|string'
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
            'tempo_liberacao_pedido'               => $request->prazo,
            'valor_adicional_pedido'               => str_replace(',','.',str_replace('%','',$request->valor_add)),
            'tamanhos'                             => json_encode($request->tamanhos) ?? [],
            'tamanho_padrao'                       => $request->tamanho_padrao,
            'caminho_imagen_produto'               => $request->caminho_imagens_produtos,
            'caminho_importacao_produto'           => $request->caminho_importacao_produtos,
            'tempo_expiracao_sessao'               => 0,
            'grupos'                               => !empty($request->grupos) ? json_encode($request->grupos) : [],
            'link_sistema_terceiros'               => $request->link_sistema_terceiros,
            'usuario_sistema_terceiros'             => $request->usuario_sistema_terceiros,
            'senha_sistema_terceiros'               => $request->senha_sistema_terceiros,
            'telefone_proprietaria'                 => $request->telefone_proprietaria,
            'email_proprietaria'                    => $request->email_proprietaria,
            'empresa_default_sistema_terceiros'     => $request->empresa_default_sistema_terceiros,
            'tipo_documento_default'                => $request->tipo_documento_default ?? '',
            'condicao_pagamento_default'            => $request->condicao_pagamento_default ?? '',
            'perfil_default'                        => (int)$request->perfil_default ?? null,
            'grupo_default'                         => (int)$request->grupo_default ?? null,
            'email_default'                         => $request->email_default ?? '',
            'empresa_default'                       => $request->empresa_default ?? null,
            'tabela_preco_default'                  => $request->tabela_preco_default ?? null
        ];

        if ($request->logo_login) {
            $mimeType = $request->file('logo_login')->getMimeType();
            $imageBase64 = base64_encode(file_get_contents($request->file('logo_login')->getRealPath()));
            $imageBase64 = 'data:' . $mimeType . ';base64,' . $imageBase64;
            
            $create['logo_login'] = $imageBase64;
        }

        if ($request->logo_sistema) {
            $mimeType = $request->file('logo_sistema')->getMimeType();
            $imageBase64 = base64_encode(file_get_contents($request->file('logo_sistema')->getRealPath()));
            $imageBase64 = 'data:' . $mimeType . ';base64,' . $imageBase64;
            
            $create['logo_sistema'] = $imageBase64;
        }
        
        return $create;
    }

    public function import(Request $request)
    {
        try {
            if ($request->importacao_produto)
            {
                DB::transaction(function () {
                    $produtoService = new ProdutoService();
                    $produtoService->inativarTodosProdutos();

                    $arquivo = $_FILES['importacao_produto'];
                    $file = fopen($arquivo['tmp_name'], 'r');
                
                    while (!feof($file)){
                            
                            $linha = fgets($file);

                            $itens = explode(';', $linha);

                            if(!empty($itens)){
                                $codigo   = $itens[0] ?? '';
                                $variacao = $itens[1] ?? 0;
                                $preco    = $itens[2] ?? 0;
                                $peso     = $itens[3] ?? 0;
                                $grupo    = $itens[4] ?? 0;
                                $descricao= $itens[5] ?? '';
                                $estoque  = $itens[6] ?? 0;
                            }
                           

                            
                            if($codigo != '' && !empty($codigo)){
                                $grupoNew = explode(' ',$descricao)[0];
                                $produtoService->processaImportacao($codigo,'',$variacao,$preco,$peso,$grupoNew,$descricao,$estoque,0);
                            }
                    } 
                    
                });

                Helper::setNotify('Produtos importados com sucesso!', 'success|check-circle');
                return redirect()->route('produto');
            }
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao importar produtos", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    

    public function importWebService()
    {
        $setupService = new SetupService();
        $empresaPadrao = $setupService->find(1)->empresa_default_sistema_terceiros;
        try {
            //DB::transaction(function () use ($empresaPadrao) {
                $produtoService = new ProdutoService();
                $wonderService = new WonderServices();
                $produtoService->inativarTodosProdutos();

                $produtoInicial = 0;
                $produtoFinal = 5000;

                for ($i=0; $i < 15; $i++) {

                    $produtos = $wonderService->consultaProduto($empresaPadrao, $produtoInicial, $produtoFinal);
                    
                    if(!empty($produtos['error']) && $produtos['error']){
                        throw new Exception("Error Processing Request", 1);
                    }
                    $produtoInicial += 5000;
                    $produtoFinal += 5000;
                    
                    foreach ($produtos as $key => $valueProdutos) {
                        
                        $grupoNew = explode(' ',$valueProdutos->descricao)[0];
                        if(substr($valueProdutos->codigo, -1) == 'F') {
                            $produtoService->processaImportacao($valueProdutos->codigo, $valueProdutos->id,0,$valueProdutos->preco,0,$grupoNew,$valueProdutos->descricao,0,1);            
                        }   
                        
                    }
                }
            //});
            Helper::setNotify('Produtos atualizados com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao atualizar os produtos", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }

    
    public function atualizarEstoque()
    {
        try {

            //DB::transaction(function () {
                $produtoService = new ProdutoService();
                $buscaProdutos = $produtoService->findBy(
                    [
                        ['inativo','=',0],
                        ['produto_terceiro_id', '!=', '']
                    ]
                );

                foreach ($buscaProdutos as $key => $value) {
                    $this->preparaAtualizacaoEstoque($value->produto_terceiro, $value->produto_terceiro_id, $value->id);
                }
            //});
            Helper::setNotify('Estoque atualizado com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao atualizar os estoques", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }

    
    public function atualizarEstoqueParcial()
    {
        try {

            //DB::transaction(function () {
                $estoqueModel = new Estoque();
                $buscaProdutos = $estoqueModel
                ->select('produto.id','produto.produto_terceiro', 'produto.produto_terceiro_id')
                ->join('produto', 'estoque.produto_id', '=', 'produto.id')
                ->where('produto.inativo','=','0')
                ->where('estoque.quantidade_estoque', '>' ,0)
                ->groupBy('produto.id','produto.produto_terceiro', 'produto.produto_terceiro_id')->get();

                foreach ($buscaProdutos as $key => $value) {

                    $this->preparaAtualizacaoEstoque($value->produto_terceiro, $value->produto_terceiro_id, $value->id);
                }
                
            //});
            Helper::setNotify('Estoque atualizado com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao atualizar os estoques", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }
    

    public function buscaFotos()
    {
        $wonderService = new WonderServices();
        $produtoService = new ProdutoService();
        $setupService = new SetupService();

        $buscaSetup = $setupService->find(1);

        

        $buscaProduto = $produtoService->findBy(
            [
                ['inativo', '=', 0],
                ['produto_terceiro_id', '!=', '']
            ]
        );
       
        foreach ($buscaProduto as $key => $produto) {
            
            $retorno = $wonderService->consultaListaImagem($produto->produto_terceiro_id);
            
            $i =1;
            if(!empty($retorno)){
                $produtoService->update(['existe_foto'=> true], $produto->id);
            }else{
                $produtoService->update(['existe_foto'=> false], $produto->id);
            }
            foreach ($retorno as $key => $value) {

                $nomeAux = $value->principal == 'S' ? $produto->produto_terceiro : $produto->produto_terceiro.'_'.$i;
                $this->buscaFoto($value->links[0]->href, base_path()."/public/".$buscaSetup->caminho_imagen_produto.$nomeAux.'.jpeg');
                if($value->principal == 'N') {
                    $i++;
                }
            }  
        }
        Helper::setNotify('Fotos atualizado com sucesso!', 'success|check-circle');
        return redirect()->back()->withInput();
        
    }

    public function buscaFoto($caminho, $caminhoDestino)
    {
        
        $wonderService = new WonderServices();
        $base64 = $wonderService->consultaFoto($caminho);
        Helper::base64_to_jpeg($base64, $caminhoDestino);
        
    }

    public function buscaPreco($idProduto)
    {
        //try {

            //DB::transaction(function () {
                
                $estoqueService = new EstoqueService();
                $wonderService = new WonderServices();
                $produtoService = new ProdutoService();
                
                $setupService = new SetupService();
                $buscaSetup = $setupService->find(1);

                $empresa = $this->empresaService->findOneBy(
                    [
                        ['id', '=', $buscaSetup->empresa_default]
                    ]
                );
                
                $buscaProdutos = $produtoService->findOneBy(
                    [
                        ['id', '=', $idProduto]
                    ]
                );
                
                $buscaPreco = $wonderService->consultaPreco($buscaProdutos->produto_terceiro_id);
                /*
                $buscaIdEstoque = $estoqueService->findBy(
                    [
                        ['produto_id', '=', $idProduto]
                    ]
                );
                
                foreach ($buscaIdEstoque as $key => $value) {
                    
                    $estoqueService->update(
                        ['valor' => $buscaPreco->preco ?? 0 * 5],
                        $value->id
                    );
                }
                */
                $precoaAtual = $buscaPreco[0]->preco ?? 0;
                DB::table('estoque')
                ->where('produto_id', $idProduto)
                ->update(['valor' => $precoaAtual * $empresa->fator_multiplicador]);
            //});
            /*
            Helper::setNotify('Estoque atualizado com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao atualizar os estoques", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        */
    }

    public function preparaAtualizacaoEstoque($produto_terceiro, $produto_terceiro_id, $idProduto)
    {   
        if(substr($produto_terceiro, -1) == 'F') {
                        
                    
            $estoqueEmpresas = $this->wonderService->consultaEstoque($produto_terceiro_id);
            
            foreach ($estoqueEmpresas as $key => $valueProdutos) {

                if(!empty($valueProdutos->id_produto) && !empty($valueProdutos->empresa) && $valueProdutos->quantidade >= 0) {
                    
                    $buscaEmpresa = $this->empresaService->findOneBy(
                        [
                            ['empresa_terceiro_id', '=', $valueProdutos->empresa]
                        ]
                    );

                    if(!empty($buscaEmpresa) ){
                        $buscaEstoque = $this->estoqueService->findOneBy(
                            [
                                ['empresa_id', '=', $buscaEmpresa->id],
                                ['produto_id', '=', $idProduto, "AND"]
                            ]
                        );
                        
                        if(!empty($buscaEstoque)){
                            
                            $this->estoqueService->update(
                                ['quantidade_estoque' => $valueProdutos->quantidade],
                                $buscaEstoque->id
                            );
                        }else{
                            
                            $this->estoqueService->create(
                                [
                                    'empresa_id'  => $buscaEmpresa->id,
                                    'produto_id'  => $idProduto ,
                                    'quantidade_estoque' => $valueProdutos->quantidade
                                ]
                            );
                        } 
                    }
                }
                
            }
            
            $this->buscaPreco($idProduto);
        }
    } 
}
