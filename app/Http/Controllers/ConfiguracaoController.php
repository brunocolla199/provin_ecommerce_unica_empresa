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

class ConfiguracaoController extends Controller
{

    protected $setupService;
    protected $grupoService;
    protected $produtoService;
    protected $empresaService;
    protected $wonderService;
    protected $estoqueService;

    public function __construct(SetupService $setup, GrupoProdutoService $grupoProduto, ProdutoService $produto, EmpresaService $empresaService, WonderServices $wonderService, EstoqueService $estoqueService)
    {
        $this->middleware('auth');
        $this->setupService = $setup;
        $this->grupoService = $grupoProduto;
        $this->produtoService = $produto;
        $this->empresaService = $empresaService;
        $this->wonderService = $wonderService;
        $this->estoqueService = $estoqueService;
    }
    
    public function index()
    {
        $configuracao = $this->setupService->findAll()->first();
        $tamanhos     = [4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34];
        $grupos       = $this->grupoService->findBy(
            [
                ['inativo','=',0]
            ]
        );
        
        return view('admin.configuracao.index', compact('configuracao','tamanhos','grupos'));
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
                $this->setupService->update(
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
            'grupos'                               => json_encode($request->grupos) ?? [],
            'link_sistema_terceiros'               => $request->link_sistema_terceiros,
            'usuario_sistema_terceiros'             => $request->usuario_sistema_terceiros,
            'senha_sistema_terceiros'               => $request->senha_sistema_terceiros,
            'telefone_proprietaria'                 => $request->telefone_proprietaria,
            'email_proprietaria'                    => $request->email_proprietaria,
            'empresa_default_sistema_terceiros'     => $request->empresa_default_sistema_terceiros
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
                    $this->produtoService->inativarTodosProdutos();

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
                                $this->produtoService->processaImportacao($codigo,$variacao,$preco,$peso,$grupo,$descricao,$estoque,0);
                            }
                    } 
                    
                });

                Helper::setNotify('Produtos importados com sucesso!', 'success|check-circle');
                return redirect()->route('produto');
            }
        } catch (\Throwable $th) {
            var_dump($th);
            die();
            Helper::setNotify("Erro ao importar produtos", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    

    public function importWebService()
    {
        $empresaPadrao = $this->setupService->find(1)->empresa_default_sistema_terceiros;
        try {
            DB::transaction(function () use ($empresaPadrao) {
                $this->produtoService->inativarTodosProdutos();
                $produtos = $this->wonderService->consultaProduto($empresaPadrao);
                

                foreach ($produtos as $key => $valueProdutos) {
                    
                    
                    if($valueProdutos->qtddisponivel > 0){
                        
                        $this->produtoService->processaImportacao($valueProdutos->codigo,0,$valueProdutos->preco,0,$valueProdutos->descricaocategoria,$valueProdutos->descricao,$valueProdutos->qtddisponivel,1);            
                    }
                    
                    
                }
                die();
            });
            Helper::setNotify('Produtos atualizados com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar os produtos", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }

    public function atualizarEstoqueFranquia()
    {
        try {

            DB::transaction(function () {
                $buscaEmpresas = $this->empresaService->findBy(
                    [
                        ['inativo','=',0],
                        ['empresa_terceiro_id','!=',0,"AND"],
                        ['empresa_terceiro_id','!=',null,"AND"]
                    ]
                );

                foreach ($buscaEmpresas as $key => $value) {

                    //zera estoque de todos produtos
                    $buscaProduto = $this->estoqueService->zeraEstoqueEmpresa($value->id);
                    //busca Produto Franqueada
                    $produtos = $this->wonderService->consultaProduto($value->empresa_terceiro_id);
        
                    foreach ($produtos as $key => $valueProdutos) {
                    //atualiza produto q tiverem estoque
                        if($valueProdutos->qtddisponivel > 0){
                            
                            $this->produtoService->processaImportacao($valueProdutos->codigo,0,$valueProdutos->preco,0,$valueProdutos->descricaocategoria,$valueProdutos->descricao,0,1);
                            
                            $buscaProdutoInterno = $this->produtoService->findOneBy(
                                [
                                    ['produto_terceiro_id','=',$valueProdutos->codigo]
                                ]
                            );
                            $buscaEstoque = $this->estoqueService->findOneBy(
                                [
                                    ['empresa_id','=',$value->id],
                                    ['produto_id','=',$buscaProdutoInterno->id,"AND"]
                                ]
                            );
                            if($buscaEstoque){
                                $this->estoqueService->update(
                                    ['quantidade_estoque' => $valueProdutos->qtddisponivel],
                                    $buscaEstoque->id
                                );
                            }else{
                                $this->estoqueService->create(
                                    [
                                        'empresa_id'  => $value->id,
                                        'produto_id'  => $buscaProdutoInterno->id ,
                                        'quantidade_estoque' => $valueProdutos->qtddisponivel
                                    ]
                                );
                            } 
                        }  
                    }
                }
            });
            Helper::setNotify('Estoque atualizado com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            dd($th);
            Helper::setNotify("Erro ao atualizar os estoques", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }
}
