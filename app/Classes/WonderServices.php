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
use Illuminate\Support\Facades\Auth;

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
    public function __construct($usuarioWebService = '', $senhaWebService = '')
    {
        set_time_limit(100000000);


        $setupService = new SetupService();
        $this->buscaSetup = $setupService->find(1);
        $this->linkWebService = $this->buscaSetup->link_sistema_terceiros;
        
        $this->usuarioWebService = $usuarioWebService != '' ? $usuarioWebService : $this->buscaSetup->usuario_sistema_terceiros;
        $this->senhaWebService = $senhaWebService != '' ? $senhaWebService : $this->buscaSetup->senha_sistema_terceiros;

        self::login();
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
                "produto"    => $value->produto->produto_terceiro,
                "quantidade" => $value->quantidade,
                "vlUnitario" => $value->valor_unitario,
                "vlTotal"    => $value->valor_total
            ];
        }

        $obs = [
            "sequencia" => 1,
            "texto" => "Pedido realizado pelo usuário " . $buscaPedido->usuario->name . " do representante " . $buscaPedido->usuario->empresa->razao_social
        ];
        $request = [
            "numero"     => $buscaPedido->id,
            "data"       => date('Y-m-d').'T'.date('H:i:s').'-03:00',
            "vlTotal"    => $buscaPedido->total_pedido,
            "vlDesconto" => 0,
            "vlFrete"    => $buscaPedido->acrescimos,
            "tipoPagamento" => "AV",
            "codTipoDoc"    => $this->buscaSetup->tipo_documento_default,
            "idCondPagto"   => $this->buscaSetup->condicao_pagamento_default,
            "cliente"    => [
                "nomeRazaoSocial" => trim(Auth::user()->empresa->razao_social),
                "nomeFantasia"    => trim(Auth::user()->empresa->nome_fantasia),
                "cpfCnpj"         => trim(Auth::user()->empresa->cpf_cnpj),
                "tipoPessoa"      => strlen(trim(Auth::user()->empresa->cpf_cnpj)) == 14 ? 'F' : 'J',
                "rgInscEst"       => trim(Auth::user()->empresa->rg_inscricao_estadual),
                "cidade"          => trim(Auth::user()->empresa->cidade->nome),
                "uf"              => trim(Auth::user()->empresa->cidade->sigla_estado),
                "endereco"        => trim(Auth::user()->empresa->endereco),
                "bairro"          => trim(Auth::user()->empresa->bairro),
                "referencia"      => trim(Auth::user()->empresa->complemento),
                "cep"             => trim(Auth::user()->empresa->cep),
                "email"           => trim(Auth::user()->empresa->email),
                "fone1"           => trim(Auth::user()->empresa->telefone),
                "fone2"           => ''
            ],
            "itens"      => $itens,
            "mensagens"  => [$obs],
            "parcelas"   => []
        ];

        return $request;
    }

    public function consultaProduto($empresa, $produtoInicial, $numeroMaxProduto)
    {        
        try {
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos?first=' . $produtoInicial . '&max=' . $numeroMaxProduto . '&empresa='.$empresa;
            
            $response = $this->HTTP_CLIENT->get($url);
            
            $body = $response->getBody()->getContents();
            return json_decode($body);
               
        } catch (RequestException $e) {
            
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }

    public function consultaEstoque($idProduto)
    {
        try {
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos/'. $idProduto .'/estoque';
            
            $response = $this->HTTP_CLIENT->get($url);
            
            $body = $response->getBody()->getContents();
            return json_decode($body);
               
        } catch (RequestException $e) {
            
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }
    
    public function consultaListaImagem($idProduto)
    {
        try {
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos/' . $idProduto . '/imagens';
            
            $response = $this->HTTP_CLIENT->get($url);
            
            $body = $response->getBody()->getContents();
            return json_decode($body);
               
        } catch (RequestException $e) {
            
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }

    public function consultaFoto($caminho)
    {   
        $this->usuarioWebService = $this->buscaSetup->usuario_sistema_terceiros;
        $this->senhaWebService = $this->buscaSetup->senha_sistema_terceiros;

        self::login();     
        try {
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'authorization' => $this->token,
                        'Accept' => 'image/jpeg'  
                    ]
                ]
            );
        
            $response = $this->HTTP_CLIENT->get($caminho);
            //dd($response);
            
            $body = $response->getBody()->getContents();
            $base64 = base64_encode($body);
            $mime = "image/jpeg";
            $img = ('data:' . $mime . ';base64,' . $base64);
            
            return $img;
               
        } catch (RequestException $e) {
            
            return ['error' => true, 'response' => $e->getMessage()];
        }
    }

    public function consultaPreco($idProduto)
    {

        try {

            $tabelaPreco = $this->buscaSetup->tabela_preco_default ?? 8;
            $this->HTTP_CLIENT = new Client(
                [
                    'headers' => [
                        'content-type'  => 'application/json',
                        'authorization' => $this->token    
                    ]
                ]
            );
        
            $url = $this->linkWebService.'/probusweb/seam/resource/probusrest/api/produtos/'. $idProduto .'/preco_tabela_preco?tabelaPreco=' . $tabelaPreco ;
            
            $response = $this->HTTP_CLIENT->get($url);
            
            $body = $response->getBody()->getContents();
            return json_decode($body);
               
        } catch (RequestException $e) {
            
            return ['error' => true, 'response' => $e->getMessage()];
        }

    }


}