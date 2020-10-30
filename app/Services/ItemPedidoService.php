<?php

namespace App\Services;

use App\Repositories\ItemPedidoRepository;


class ItemPedidoService
{

    public $itemPedidoRepository;
    public $produtoService;

    public function __construct(ItemPedidoRepository $itemPedido, ProdutoService $produtoService)
    {
        $this->itemPedidoRepository = $itemPedido;
        $this->produtoService = $produtoService;
    }

    public function find($id, array $with = [])
    {
        return $this->itemPedidoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->itemPedidoRepository->findAll($with,$orderBy);
    }


    public function create($pedido_id,$produto_id,$quantidade,$valor_unitario,$valor_total,$tamanho)
    {   
        $request = self::montaRequest($pedido_id,$produto_id,$quantidade,$valor_unitario,$valor_total,$tamanho);
       
        return $this->itemPedidoRepository->create($request);
    }

    public function update($id, $pedido_id,$produto_id,$quantidade,$valor_unitario,$valor_total,$tamanho)
    {
        $request = self::montaRequest($pedido_id,$produto_id,$quantidade,$valor_unitario,$valor_total,$tamanho);
        return $this->itemPedidoRepository->update($request, $id);
    }

    public function delete($_delete)
    {
        return $this->itemPedidoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->itemPedidoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

    

    public function montaRequest($pedido_id,$produto_id,$quantidade,$valor_unitario,$valor_total,$tamanho)
    {
        return [
            "pedido_id"      => $pedido_id,
            "produto_id"     => $produto_id,
            "quantidade"     => (int)$quantidade,
            "valor_unitario" => $valor_unitario,
            "valor_total"    => $valor_total,
            "tamanho"        => $tamanho
        ];
    }

    public function recalcular($id, $id_Produto,$quantidade)
    {
        $buscaProduto = $this->produtoService->find($id_Produto);
        $valor_unitario = $buscaProduto->valor;
        $total = $quantidade * $buscaProduto->valor;

        $buscaItemPedido = self::find($id);

        self::update($id,$buscaItemPedido->pedido_id,$id_Produto,$quantidade,$valor_unitario,$total,$buscaItemPedido->tamanho);

        return $total;
    }

    
}
