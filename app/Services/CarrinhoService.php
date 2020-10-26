<?php

namespace App\Services;

use App\Classes\Helper;
use App\Services\UserService;
use Illuminate\Support\Facades\{DB, Auth};


class CarrinhoService
{
    protected $userService;
    protected $pedidoService;
    protected $itemPedidoService;

    public function __construct(UserService $user, PedidoService $pedido, ItemPedidoService $item)
    {
        $this->userService = $user;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
    }

    public function addCarrinho($id_produto,$tipo_pedido,$tamanho)
    {

        $empresa = Auth::user()->empresa_id;
        $buscaUsuario = $this->userService->findBy(
            [
                ['empresa_id','=',$empresa]
            ]
        );

        $usuariosIn = [];
        foreach ($buscaUsuario as $key => $value) {
            array_push($usuariosIn,$value->id);
        }
    
        $buscaPedido =$this->pedidoService->findBy(
            [
                ['excluido','=',0,"AND"],
                ['status_pedido_id','=',1,"AND"],
                ['tipo_pedido_id','=',$tipo_pedido,"AND"],
                ['user_id','',$usuariosIn,"IN"]
            ]
        );

        //Se achou pedido da empresa ALTERA caso contrario CRIA
        if(!empty($buscaPedido[0])){
            //update
            $buscaExistItem =  $this->itemPedidoService->findBy(
                [
                    ['produto_id','=',$id_produto],
                    ['pedido_id','=',$buscaPedido[0]->id,'AND'],
                    ['tamanho','=',$tamanho,'AND']
                ]
            );
            try {
                if(!empty($buscaExistItem[0])){
                    $this->itemPedidoService->update($buscaExistItem[0]->id,$buscaPedido[0]->id,$id_produto,$buscaExistItem[0]->quantidade +1,0,0,$tamanho);
                }else{
                    $this->itemPedidoService->create($buscaPedido[0]->id,$id_produto,1,0,0,$tamanho);   
                }
                $this->pedidoService->recalcular($buscaPedido[0]->id);
                
                Helper::setNotify('Produto adicionado com sucesso!', 'success|check-circle');
                return true;

            } catch (\Throwable $th) {
                Helper::setNotify("Erro ao adicionar o produto", 'danger|close-circle');
                return false;
            } 
            
        }else{
            
            try {
                //cria
                DB::transaction(function () use ($tipo_pedido,$id_produto,$tamanho) {
                    $create = $this->pedidoService->create($tipo_pedido,1,Auth::user()->id,0,0,null,0,0,'');
                    $this->itemPedidoService->create($create->id,$id_produto,1,0,0,$tamanho);
                    $this->pedidoService->recalcular($create->id);
                });
                
                Helper::setNotify('Produto adicionado com sucesso!', 'success|check-circle');
                return true;

            } catch (\Throwable $th) {
                Helper::setNotify("Erro ao adicionar o produto", 'danger|close-circle');
                return false;
            } 
        }
    }
}