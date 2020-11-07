<?php

namespace App\Classes;

use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\SetupService;
use App\Services\EmpresaService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Cookie\CookieJar;

class WonderServices
{
    protected $linkWebService;
    protected $usuarioWebService;
    protected $senhaWebService;

    protected $token;

    protected $pedidoService;
    protected $itemPedidoService;
    protected $setupService;
    protected $empresaService;

    public $buscaSetup;

    private $HTTP_CLIENT = null;

    /*
    * Construtor
    */
    public function __construct(PedidoService $pedidoService, ItemPedidoService $itemPedidoService, SetupService $setupService, EmpresaService $empresaService)
    {
        $this->pedidoService     = $pedidoService;
        $this->itemPedidoService = $itemPedidoService;
        $this->setupService      = $setupService;
        $this->empresaService    = $empresaService;

        $this->buscaSetup = $this->setupService->find(1);
        $this->linkWebService = $this->buscaSetup->link_sistema_terceiros;
        
        
    }

   
    public function login()
    {
        try {

            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'Accept'     => 'application/json',
                        
                    ]
                ]
            );

            $dados = ["usuario"=> $this->usuarioWebService, "password"=> $this->senhaWebService];
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/v1/session';
            $response = $this->HTTP_CLIENT->post($url,[
                RequestOptions::JSON =>  $dados
            ]);
            $body = $response->getBody()->getContents();
            $result = json_decode($body);
            if ($result->token) {
                $this->token = $result->token;
            } 
        } catch (RequestException $e) {
            ///dd($e);
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }

    
    public function enviarPedido($idPedido)
    {
        $this->usuarioWebService = $this->buscaSetup->usuario_sistema_terceiros;
        $this->senhaWebService = $this->buscaSetup->senha_sistema_terceiros;

        self::login();
        
       
        try {
            $request = self::montaRequestPedido($idPedido);

            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/pedidos';
            
            $response = $this->HTTP_CLIENT->post($url,[
                RequestOptions::JSON =>  $request
            ]);
            dd($response);
            $body = $response->getBody()->getContents();
            $result = json_decode($body);
            dd($result);


            return $array[1];

        } catch (RequestException $e) {
            dd($e);
            return ['error' => true, 'response' => $e->getMessage()];
        }
        
        
    }

    public function montaRequestPedido($idPedido)
    {
        $buscaPedido = $this->pedidoService->find($idPedido);

        $buscaItensPedido = $this->itemPedidoService->findBy(
            [
                ["pedido_id","=",$idPedido]
            ]
        );

        $itens = [];
        foreach ($buscaItensPedido as $key => $value) {
            $itens[$key] = [
                "produto"    => $value->produto->produto_terceiro_id,
                "quantidade" => $value->quantidade,
                "vlUnitario" => $value->valor_unitario,
                "vlTotal"    => $value->valor_total
            ];
        }

        $request = [
            "numero"     => $buscaPedido->id,
            "data"       => date('Y-m-d').'T'.date('H:i:s').'-03:00',
            "vlTotal"    => $buscaPedido->total_pedido,
            "vlDesconto" => 0,
            "vlFrete"    => $buscaPedido->acrescimos,
            "tipoPagamento" => "AV",
            "codTipoDoc"    => '62',
            "idCondPagto"   => '2',
            "cliente"    => [
                "nomeRazaoSocial" => trim($buscaPedido->usuario->empresa->razao_social),
                "nomeFantasia"    => trim($buscaPedido->usuario->empresa->nome_fantasia),
                "cpfCnpj"         => trim($buscaPedido->usuario->empresa->cpf_cnpj),
                "tipoPessoa"      => trim($buscaPedido->usuario->empresa->tipo_pessoa),
                "rgInscEst"       => trim($buscaPedido->usuario->empresa->rg_inscricao_estadual),
                "cidade"          => trim($buscaPedido->usuario->empresa->cidade->nome),
                "uf"              => trim($buscaPedido->usuario->empresa->cidade->sigla_estado),
                "endereco"        => trim($buscaPedido->usuario->empresa->endereco),
                "bairro"          => trim($buscaPedido->usuario->empresa->bairro),
                "referencia"      => trim($buscaPedido->usuario->empresa->complemento),
                "cep"             => trim($buscaPedido->usuario->empresa->cep),
                "email"           => trim($buscaPedido->usuario->empresa->email),
                "fone1"           => trim($buscaPedido->usuario->empresa->telefone),
                "fone2"           => ''
            ],
            "itens"      => $itens,
            "mensagens"  => [],
            "parcelas"   => []
        ];

        return $request;
    }

    public function consultaEstoque($empresa_id,$id_produto)
    {
        $buscaEmpresa = $this->empresaService->find($empresa_id);

        $this->usuarioWebService = $buscaEmpresa->usuario_sistema_terceiros;
        $this->senhaWebService   = $buscaEmpresa->senha_sistema_terceiros;

        self::login();
        try {
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos/'.$id_produto.'/estoque';
            
            $response = $this->HTTP_CLIENT->get($url);
            dd($response);
            $body = $response->getBody()->getContents();
            $result = json_decode($body);
            dd($result);
        } catch (RequestException $e) {
            dd($e);
            return ['error' => true, 'response' => $e->getMessage()];
        }

    }


    public function consultaProduto($inicio, $fim)
    {

        $this->usuarioWebService = $this->buscaSetup->usuario_sistema_terceiros;
        $this->senhaWebService = $this->buscaSetup->senha_sistema_terceiros;

        self::login();
        
        try {
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos?first='.$inicio.'&max='.$fim;
            
            $response = $this->HTTP_CLIENT->get($url);
            dd($response);
            $body = $response->getBody()->getContents();
            $result = json_decode($body);
            dd($result);
        } catch (RequestException $e) {
            dd($e);
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }
    
    


}