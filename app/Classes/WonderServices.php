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
            "tipoPagamento" => "AV",
            "cliente"    => [
                "nomeRazaoSocial" => $buscaPedido->usuario->empresa->razao_social,
                "nomeFantasia"    => $buscaPedido->usuario->empresa->nome_fantasia,
                "cpfCnpj"         => $buscaPedido->usuario->empresa->cpf_cnpj,
                "tipoPessoa"      => $buscaPedido->usuario->empresa->tipo_pessoa,
                "rgInscEst"       => '',
                "cidade"          => $buscaPedido->usuario->empresa->cidade->nome,
                "uf"              => $buscaPedido->usuario->empresa->cidade->sigla_estado,
                "endereco"        => $buscaPedido->usuario->empresa->endereco,
                "bairro"          => $buscaPedido->usuario->empresa->bairro,
                "referencia"      => $buscaPedido->usuario->empresa->complemento,
                "cep"             => $buscaPedido->usuario->empresa->cep,
                "email"           => $buscaPedido->usuario->empresa->email,
                "fone1"           => $buscaPedido->usuario->empresa->telefone,
                "fone2"           => ''
            ],
            "itens"      => $itens,
            "mensagens"  => [],
            "parcelas"   => []
        ];

        return $request;
    }

    public function consultaEstoque($empresa_id)
    {
        $buscaEmpresa = $this->empresaService->find($empresa_id);

        $this->usuarioWebService = $buscaEmpresa->usuario_sistema_terceiros;
        $this->senhaWebService   = $buscaEmpresa->senha_sistema_terceiros;

        self::login();
        $request = self::montaRequestProduto();
        $resul   = shell_exec("curl -i -k -X POST -H 'Content-Type: application/json' -H 'Cookie: JSESSIONID=".$this->token.";' -d '".$request."' ".$this->linkWebService."/probusweb/seam/resource/probusrest/ecommerce/estoque");

    }
    
    public function montaRequestProduto()
    {

    }


}