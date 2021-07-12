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

    public function __construct()
    {
        $this->middleware('auth');
        set_time_limit(99999999);
    }
    
    public function index()
    {
        $setupService = new SetupService();
        $grupoService = new GrupoProdutoService();

        $configuracao = $setupService->findAll()->first();
        $tamanhos     = [4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34];
        $grupos       = $grupoService->findBy(
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
                                $produtoService->processaImportacao($codigo,$variacao,$preco,$peso,$grupoNew,$descricao,$estoque,0);
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
            DB::transaction(function () use ($empresaPadrao) {
                $produtoService = new ProdutoService();
                $wonderService = new WonderServices();
                $produtoService->inativarTodosProdutos();

                $produtoInicial = 0;
                $produtoFinal = 5000;

                for ($i=0; $i < 5; $i++) {

                    $produtos = $wonderService->consultaProduto($empresaPadrao, $produtoInicial, $produtoFinal);
                    $produtoInicial += 5000;
                    $produtoFinal += 5000;
                    foreach ($produtos as $key => $valueProdutos) {
                        
                        
                        if($valueProdutos->qtddisponivel > 0){
                            $grupoNew = explode(' ',$valueProdutos->descricao)[0];
                            
                            $produtoService->processaImportacao($valueProdutos->codigo,0,$valueProdutos->preco,0,$grupoNew,$valueProdutos->descricao,$valueProdutos->qtddisponivel,1);            
                        }
                        
                        
                    }
                }
                
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
                $empresaService = new EmpresaService();
                $estoqueService = new EstoqueService();
                $wonderService = new WonderServices();
                $produtoService = new ProdutoService();
                $buscaEmpresas = $empresaService->findBy(
                    [
                        ['inativo','=',0],
                        ['empresa_terceiro_id','!=',0,"AND"],
                        ['empresa_terceiro_id','!=',null,"AND"]
                    ]
                );

                foreach ($buscaEmpresas as $key => $value) {

                    //zera estoque de todos produtos
                    $buscaProduto = $estoqueService->zeraEstoqueEmpresa($value->id);

                    $produtoInicial = 0;
                    $produtoFinal = 5000;

                    for ($i=0; $i < 5; $i++) {

                        //busca Produto Franqueada
                        $produtos = $wonderService->consultaProduto($value->empresa_terceiro_id, $produtoInicial, $produtoFinal);

                        $produtoInicial += 5000;
                        $produtoFinal += 5000;
            
                        foreach ($produtos as $key => $valueProdutos) {
                        //atualiza produto q tiverem estoque
                            if($valueProdutos->qtddisponivel > 0){
                                //dd($valueProdutos);
                                $grupoNew = explode(' ',$valueProdutos->descricao)[0];
                            
                                $produtoService->processaImportacao($valueProdutos->codigo,0,$valueProdutos->preco,0,$grupoNew,$valueProdutos->descricao,0,1);
                                
                                $buscaProdutoInterno = $produtoService->findOneBy(
                                    [
                                        ['produto_terceiro_id','=',$valueProdutos->codigo]
                                    ]
                                );
                                $buscaEstoque = $estoqueService->findOneBy(
                                    [
                                        ['empresa_id','=',$value->id],
                                        ['produto_id','=',$buscaProdutoInterno->id,"AND"]
                                    ]
                                );
                                if($buscaEstoque){
                                    $estoqueService->update(
                                        [
                                            'quantidade_estoque' => $valueProdutos->qtddisponivel,
                                            'valor' => $valueProdutos->preco
                                        ],
                                        $buscaEstoque->id
                                    );
                                }else{
                                    $estoqueService->create(
                                        [
                                            'empresa_id'  => $value->id,
                                            'produto_id'  => $buscaProdutoInterno->id ,
                                            'quantidade_estoque' => $valueProdutos->qtddisponivel,
                                            'valor' => $valueProdutos->preco
                                        ]
                                    );
                                } 
                            }  
                        }
                    }
                }
            });
            Helper::setNotify('Estoque atualizado com sucesso!', 'success|check-circle');
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar os estoques", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
        
    }
}
