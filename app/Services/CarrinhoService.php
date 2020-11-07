<?php

namespace App\Services;

use App\Classes\Helper;
use App\Services\UserService;
use App\Services\PedidoService;
use App\Services\ProdutoService;
use App\Services\ItemPedidoService;
use App\Services\SetupService;
use Illuminate\Support\Facades\{DB, Auth};


class CarrinhoService
{
    protected $userService;
    protected $pedidoService;
    protected $itemPedidoService;
    protected $produtoService;
    protected $setupService;

    public function __construct(UserService $user, PedidoService $pedido, ItemPedidoService $item, ProdutoService $produto, SetupService $setup)
    {
        $this->userService = $user;
        $this->pedidoService = $pedido;
        $this->itemPedidoService = $item;
        $this->produtoService = $produto;
        $this->setupService = $setup;
    }

    public function addCarrinho($id_produto,$tipo_pedido,$tamanho,$quantidade)
    {
        $verificaEstoque = $this->produtoService->find($id_produto);
        if(!$verificaEstoque){
            Helper::setNotify("Produto não se encontra mais em estoque.", 'danger|close-circle');
            return false;
        }

        $buscaPedido =$this->pedidoService->buscaPedidoCarrinho($tipo_pedido);
        

        $buscaSetup = $this->setupService->find(1);
        $valorAdicional = $tipo_pedido == 1 ? $buscaSetup->valor_adicional_pedido : 0;
        
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
                DB::transaction(function () use ($buscaExistItem,$buscaPedido,$id_produto,$quantidade,$tamanho){
                    if(!empty($buscaExistItem[0])){
                        $this->itemPedidoService->update($buscaExistItem[0]->id,$buscaPedido[0]->id,$id_produto,$buscaExistItem[0]->quantidade +1,0,0,$tamanho);
                    }else{
                        
                        $this->itemPedidoService->create($buscaPedido[0]->id,$id_produto,$quantidade,0,0,$tamanho);   
                    }
                    
                    $this->pedidoService->recalcular($buscaPedido[0]->id);  
                }); 
                 
                Helper::setNotify('Produto adicionado com sucesso!', 'success|check-circle');
                return true;

            } catch (\Throwable $th) {
                
                Helper::setNotify("Erro ao adicionar o produto", 'danger|close-circle');
                return false;
            } 
            
        }else{
            
            try {
                //cria
                DB::transaction(function () use ($tipo_pedido,$id_produto,$tamanho,$quantidade,$valorAdicional) {
                    $create = $this->pedidoService->create($tipo_pedido,1,Auth::user()->id,0,0,null,$valorAdicional,0,'',null);
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