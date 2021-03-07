<?php

namespace App\Classes;

use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\SetupService;
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

    public $buscaSetup;

    private $HTTP_CLIENT = null;

    /*
    * Construtor
    */
    public function __construct()
    {
        
        $setupService = new SetupService();
        $this->buscaSetup = $setupService->find(1);
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
            
            $body = $response->getBody()->getContents();
            $result = json_decode($body);
            
            return $result->id;

        } catch (RequestException $e) {
            $msg = explode("response:",$e->getMessage());
            return $msg[1];
        }
        
        
    }

    public function montaRequestPedido($idPedido)
    {
        $pedidoService = new PedidoService();
        $itemPedidoService = new ItemPedidoService();

        $buscaPedido = $pedidoService->find($idPedido);

        $buscaItensPedido = $itemPedidoService->findBy(
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
                "nomeRazaoSocial" => trim($buscaPedido->usuario->name),
                "nomeFantasia"    => trim($buscaPedido->usuario->name),
                "cpfCnpj"         => trim($buscaPedido->usuario->cpf_cnpj),
                "tipoPessoa"      => trim('F'),
                "rgInscEst"       => trim('ISENTO'),
                "cidade"          => trim('Erechim'),
                "uf"              => trim('RS'),
                "endereco"        => trim('Av. Sete Setembro'),
                "bairro"          => trim('Centro'),
                "referencia"      => trim(''),
                "cep"             => trim('99704-032'),
                "email"           => trim($buscaPedido->usuario->email),
                "fone1"           => trim($buscaPedido->usuario->telefone),
                "fone2"           => ''
            ],
            "itens"      => $itens,
            "mensagens"  => [],
            "parcelas"   => []
        ];

        return $request;
    }

    public function consultaProduto($empresa)
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
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos?empresa='.$empresa;
            
            $response = $this->HTTP_CLIENT->get($url);
            
            $body = $response->getBody()->getContents();
            return json_decode($body);
               
        } catch (RequestException $e) {
            
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }
    
    


}