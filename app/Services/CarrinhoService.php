<?php

namespace App\Services;

use App\Classes\Helper;
use App\Services\PedidoService;
use App\Services\ProdutoService;
use App\Services\ItemPedidoService;
use App\Services\SetupService;
use Illuminate\Support\Facades\{DB, Auth};


class CarrinhoService
{
    public function __construct()
    {    }

    public function addCarrinho($id_produto,$tipo_pedido,$tamanho,$quantidade)
    {
        $produtoService = new ProdutoService();
        $pedidoService = new PedidoService();
        $setupService = new SetupService();
        $itemPedidoService = new ItemPedidoService();

        $verificaEstoque = $produtoService->find($id_produto);
        if($verificaEstoque['quantidade_estoque'] < $quantidade){
            Helper::setNotify("Produto não se encontra mais em estoque.", 'danger|close-circle');
            return false;
        }
        
        $buscaPedido =$pedidoService->buscaPedidoCarrinho($tipo_pedido);
        
        $buscaSetup = $setupService->find(1);
        $valorAdicional = 0;
        //Se achou pedido da empresa ALTERA caso contrario CRIA
        if($buscaPedido->count() > 0){
            //update
           
            $buscaExistItem =  $itemPedidoService->findBy(
                [
                    ['produto_id','=',$id_produto],
                    ['pedido_id','=',$buscaPedido[0]->id,'AND'],
                    ['tamanho','=',$tamanho,'AND']
                ]
            );
            try {
                DB::transaction(function () use ($itemPedidoService, $produtoService, $pedidoService, $buscaExistItem,$buscaPedido,$id_produto,$quantidade,$tamanho,$verificaEstoque){
                    if($buscaExistItem->count() > 0){
                        $itemPedidoService->update($buscaExistItem[0]->id,$buscaPedido[0]->id,$id_produto,$buscaExistItem[0]->quantidade +1,0,0,$tamanho);
                    }else{
                        
                        $itemPedidoService->create($buscaPedido[0]->id,$id_produto,$quantidade,0,0,$tamanho);   
                    }
                    $produtoService->update(['quantidade_estoque' => $verificaEstoque['quantidade_estoque']-$quantidade],$id_produto);
                    $pedidoService->recalcular($buscaPedido[0]->id);  
                }); 
                 
                //Helper::setNotify('Produto adicionado com sucesso!', 'success|check-circle');
                
                return ($buscaExistItem->count() > 0 ? $buscaExistItem[0]->quantidade : 0)  + $quantidade;

            } catch (\Throwable $th) {
                
                Helper::setNotify("Erro ao adicionar o produto", 'danger|close-circle');
                return false;
            } 
            
        }else{
            
            try {
                //cria
                DB::transaction(function () use ($pedidoService, $itemPedidoService, $tipo_pedido,$id_produto,$tamanho,$quantidade,$valorAdicional) {
                    $create = $pedidoService->create($tipo_pedido,1,Auth::user()->id,0,0,null,$valorAdicional,0,'',null);
                    $itemPedidoService->create($create->id,$id_produto,$quantidade,0,0,$tamanho);
                    $pedidoService->recalcular($create->id);
                });
                
                //Helper::setNotify('Produto adicionado com sucesso!', 'success|check-circle');
                return true;

            } catch (\Throwable $th) {
                Helper::setNotify("Erro ao adicionar o produto", 'danger|close-circle');
                return false;
            } 
        }
    }

    public function removerCarrinho ($idItem)
    {
        $itemPedidoService = new ItemPedidoService();
        $produtoService = new ProdutoService();
        $pedidoService = new PedidoService();
        try {

            DB::transaction(function () use ($idItem, $pedidoService, $produtoService, $itemPedidoService){
                $buscaItem     = $itemPedidoService->find($idItem);
                $buscaProduto  = $produtoService->find($buscaItem['produto_id']);

                $itemPedidoService->delete($idItem);
                $produtoService->update(['quantidade_estoque' => $buscaProduto['quantidade_estoque']+$buscaItem['quantidade']],$buscaItem['produto_id']);
                $pedidoService->recalcular($buscaItem->pedido->id);
            });
            
            //Helper::setNotify('Produto removido com sucesso!', 'success|check-circle');
            return true;

        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao remover o produto", 'danger|close-circle');
            return false;
        }
    }
}