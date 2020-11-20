<?php 

namespace App\Services;

use App\Repositories\PedidoRepository;
use App\Services\ItemPedidoService;
use App\Services\UserService;
use App\Services\SetupService;
use Illuminate\Support\Facades\{Auth};



class PedidoService
{
    public $pedidoRepository;
    public $itemPedidoService;
    public $userService;
    public $setupService;

    public function __construct(PedidoRepository $pedido, ItemPedidoService $item, UserService $user, SetupService $setup)
    {
        $this->pedidoRepository = $pedido;
        $this->itemPedidoService = $item;
        $this->userService = $user;
        $this->setupService = $setup;
    }


    public function find($id, array $with = [])
    {
        return $this->pedidoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->pedidoRepository->findAll($with,$orderBy);
    }

    public function create($tipo_pedido_id,$status_pedido_id,$user_id,$total_pedido,$numero_itens,$previsao_entrega,$acrescimos,$excluido,$link_rastreamento, $pedido_terceiro_id = null, $data_envio_pedido = null)
    {
        $request = self::montaRequest($tipo_pedido_id,$status_pedido_id,$user_id,$total_pedido,$numero_itens,$previsao_entrega,$acrescimos,$excluido,$link_rastreamento, $pedido_terceiro_id, $data_envio_pedido);
        return $this->pedidoRepository->create($request);
    }

    public function update($id,$tipo_pedido_id,$status_pedido_id,$user_id,$total_pedido,$numero_itens,$previsao_entrega,$acrescimos,$excluido,$link_rastreamento,$pedido_terceiro_id = null, $data_envio_pedido =null)
    {
        $request = self::montaRequest($tipo_pedido_id,$status_pedido_id,$user_id,$total_pedido,$numero_itens,$previsao_entrega,$acrescimos,$excluido,$link_rastreamento,$pedido_terceiro_id, $data_envio_pedido);
        return $this->pedidoRepository->update($request,$id);
    }

    public function delete($_delete)
    {
        return $this->pedidoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->pedidoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }




    public function montaRequest($tipo_pedido_id,$status_pedido_id,$user_id,$total_pedido,$numero_itens,$previsao_entrega,$acrescimos,$excluido,$link_rastreamento, $pedido_terceiro_id = null, $data_envio_pedido= null)
    {
        return [
            'tipo_pedido_id'    => $tipo_pedido_id,
            'status_pedido_id'  => $status_pedido_id,
            'user_id'           => $user_id,
            'total_pedido'      => $total_pedido,
            'numero_itens'      => $numero_itens,
            'previsao_entrega'  => $previsao_entrega,
            'acrescimos'        => $acrescimos,
            'link_rastreamento' => $link_rastreamento,
            'excluido'          => $excluido,
            'pedido_terceiro_id'=> $pedido_terceiro_id,
            'data_envio_pedido' => $data_envio_pedido
        ];
    }

    public function recalcular($id)
    {   
        $total_itens = 0;
        $total_pedido = 0;
        $valor_adicional = 0;

        $busca_porcentagem_setup = $this->setupService->find(1);

        $itens = $this->itemPedidoService->findBy(
            [
                [
                    'pedido_id','=',$id
                ]
            ]
        );
        
        foreach ($itens as $key => $item) {
            $total_itens +=$item->quantidade;
            $retorno = $this->itemPedidoService->recalcular($item->id,$item->produto_id,$item->quantidade);
            $total_pedido += $retorno;
        }

        $pedido = self::find($id);
        $valor_adicional = $pedido->tipo_pedido_id ==1 ? $total_pedido * ($busca_porcentagem_setup['valor_adicional_pedido']/100) : 0;
        $total_pedido += $valor_adicional;
        self::update($id,$pedido->tipo_pedido_id,$pedido->status_pedido_id,$pedido->user_id,$total_pedido,$total_itens,$pedido->previsao_entrega,$valor_adicional,$pedido->excluido,$pedido->link_rastreamento);
    }

    public function buscaPedidoCarrinho($tipo_pedido)
    {
        $usuariosIn = $this->userService->buscaUsuariosMesmaEmpresa();
    
        return $this->pedidoRepository->findBy(
            [
                ['excluido','=',0,"AND"],
                ['status_pedido_id','=',1,"AND"],
                ['tipo_pedido_id','=',$tipo_pedido,"AND"],
                ['user_id','',$usuariosIn,"IN"]
            ]
        );
    }

    public function buscaUltimoPedidoNormalProcessado()
    {
        $usuariosIn = $this->userService->buscaUsuariosMesmaEmpresa();
        return $this->pedidoRepository->findBy(
            [
                ['excluido','=',0],
                ['status_pedido_id','>',1,"AND"],
                ['status_pedido_id','!=',6,"AND"],
                ['pedido_terceiro_id','!=',null,"AND"],
                ['user_id','',$usuariosIn,"IN"]
            ],[],
            [
                ['pedido_terceiro_id','desc']
            ],[],
            [1]
        );
        
        
    }
}