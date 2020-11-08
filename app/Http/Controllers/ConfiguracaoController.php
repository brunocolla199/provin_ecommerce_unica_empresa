<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SetupService;
use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB};
use function GuzzleHttp\json_encode;
use App\Services\GrupoProdutoService;
use App\Services\ProdutoService;

class ConfiguracaoController extends Controller
{

    protected $setupService;
    protected $grupoService;
    protected $produtoService;

    public function __construct(SetupService $setup, GrupoProdutoService $grupoProduto, ProdutoService $produto)
    {
        $this->middleware('auth');
        $this->setupService = $setup;
        $this->grupoService = $grupoProduto;
        $this->produtoService = $produto;
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
            'email_proprietaria'           => 'required|email:rfc,dns'
            

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
            'email_proprietaria'                    => $request->email_proprietaria
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
                //busca produtos que q estejam ativos cadastrados
                $produtosAtivos = $this->produtoService->findBy(
                    [
                        [
                            'inativo', '=' , 0
                        ]
                    ]
                );

                DB::transaction(function () use ($produtosAtivos) {
                    //Inativa todos os produtos
                    foreach ($produtosAtivos as $key => $valueProdutosAtivos) {
                       

                        $this->produtoService->update(
                            ['inativo'=>'1'],
                            $valueProdutosAtivos->id
                        );
                    }

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
                                self::processaImportacao($codigo,$variacao,$preco,$peso,$grupo,$descricao,$estoque);
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

    public function processaImportacao($codigo,$variacao,$preco,$peso,$grupo,$descricao,$estoque)
    {
        
        //Verifica Existencia do grupo
        $buscaGrupo = $this->grupoService->findBy(
            [
                ['nome','=',$grupo]
            ],
        );
        
        if(!empty($buscaGrupo[0])){
            $idGrupo = $buscaGrupo[0]->id;
        }else{
            //cadastra
            $retornoCreateGrupo = $this->grupoService->create(
                [
                'nome'    =>$grupo,
                'inativo' => 0
                ]
            );
            $idGrupo = $retornoCreateGrupo->id;
        }

        //verifica Existencia do produto
        $buscaProduto = $this->produtoService->findBy(
            [
                ['produto_terceiro_id','=',$codigo]
            ],
        );

        if(!empty($buscaProduto[0])){
            //ativa produto
            $update = self::montaRequestImportProduto($codigo,$variacao,$preco,$peso,$idGrupo,$descricao,$estoque);
            
            $this->produtoService->update(
                $update,
                $buscaProduto[0]->id
            );
        }else{
            
            //cadastra produto
            $cadastro = self::montaRequestImportProduto($codigo,$variacao,$preco,$peso,$idGrupo,$descricao,$estoque);
            
            $retornoCreateProduto = $this->produtoService->create(
               $cadastro
            );
            
        }


    }

    public function montaRequestImportProduto($codigo,$variacao,$preco,$peso,$idGrupo,$descricao,$estoque)
    {
        $produto = [
            'nome'               => $descricao,
            'produto_terceiro_id'=> $codigo,
            'inativo'            => 0,
            'grupo_produto_id'   => $idGrupo,
            'variacao'           => $variacao ?? 0,
            'peso'               => $peso ?? 0,
            'quantidade_estoque' => $estoque,
            'valor'              => str_replace(',','.',$preco),
            'tamanho'            => ''
        ];

        return $produto;
    }
}
