<?php

namespace App\Services;

use App\Classes\Helper;
use App\Services\UserService;
use App\Services\PedidoService;
use App\Services\ProdutoService;
use App\Services\ItemPedidoService;
use Illuminate\Support\Facades\{DB, Auth};


class CarrinhoService
{
    protected $userService;
    protected $pedidoService;
    protected $itemPedidoService;
    protected $produtoService;

    public function __construct(UserService $user, PedidoService $pedido, ItemPedidoService $item, ProdutoService $produto)
    {
        $this->userService = $user;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->produtoService = $produto;
    }

    public function addCarrinho($id_produto,$tipo_pedido,$tamanho,$quantidade)
    {
        $buscaProduto = $this->produtoService->find($id_produto);
        if($buscaProduto['quantidade_estoque'] < $quantidade){
            Helper::setNotify("Produto não se encontra mais em estoque.", 'danger|close-circle');
            return false;
        }

        $buscaPedido =$this->pedidoService->buscaPedidoCarrinho($tipo_pedido);
        
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
                    $this->itemPedidoService->create($buscaPedido[0]->id,$id_produto,$quantidade,0,0,$tamanho);   
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
                DB::transaction(function () use ($tipo_pedido,$id_produto,$tamanho,$quantidade) {
                    $create = $this->pedidoService->create($tipo_pedido,1,Auth::user()->id,0,0,null,0,0,'');
                    $this->itemPedidoService->create($create->id,$id_produto,$quantidade,0,0,$tamanho);
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