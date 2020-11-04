<?php

namespace App\Classes;

use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\SetupService;
use App\Services\EmpresaService;

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
        echo 'curl -k -i -d "usuario='.$this->usuarioWebService.'&password='.$this->senhaWebService.'"  -H "Content-Type:application/x-www-form-urlencoded" '.$this->linkWebService.'/probusweb/seam/resource/probusrest/integracao/session';
        die();

        $loga = shell_exec('curl -k -i -d "usuario='.$this->usuarioWebService.'&password='.$this->senhaWebService.'"  -H "Content-Type:application/x-www-form-urlencoded" '.$this->linkWebService.'/probusweb/seam/resource/probusrest/integracao/session');
        dd($loga);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $loga, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        dd($cookies);
        $this->token($cookies['JSESSIONID']);
    }

    
    public function enviarPedido($idPedido)
    {
        $this->usuarioWebService = $this->buscaSetup->usuario_sistema_terceiros;
        $this->senhaWebService = $this->buscaSetup->senha_sistema_terceiros;

        self::login();

        die();

        $request = self::montaRequestPedido($idPedido);

        $result = shell_exec("curl -i -k -X POST -H 'Content-Type: application/json' -H 'Cookie: JSESSIONID=".$this->token.";' -d '".$request."' ".$this->linkWebService."/probusweb/seam/resource/probusrest/integracao/default/novoPedido");

        $array = explode("GMT",$result);

        return $array[1];
        
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
            "codTipoDoc" => 62,
            "idCondPagto"=> 2,
            "vlTotal"    => $buscaPedido->total_pedido,
            "vlDesconto" => 0,
            "vlFrete"    => $buscaPedido->acrescimos,
            "cliente"    => [
                "nomeRazaoSocial" => $buscaPedido->empresa->razao_social,
                "nomeFantasia"    => $buscaPedido->empresa->nome_fantasia,
                "cpfCnpj"         => $buscaPedido->empresa->cpf_cnpj,
                "tipoPessoa"      => $buscaPedido->empresa->tipo_pessoa,
                "rgInscEst"       => '',
                "cidade"          => $buscaPedido->empresa->cidade->nome,
                "uf"              => $buscaPedido->empresa->cidade->sigla_estado,
                "endereco"        => $buscaPedido->empresa->endereco,
                "bairro"          => $buscaPedido->empresa->bairro,
                "referencia"      => $buscaPedido->empresa->complemento,
                "cep"             => $buscaPedido->empresa->cep,
                "email"           => $buscaPedido->empresa->email,
                "fone1"           => $buscaPedido->empresa->telefone,
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