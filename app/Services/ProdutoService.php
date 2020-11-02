<?php 

namespace App\Services;

use App\Repositories\ProdutoRepository;

class ProdutoService 
{
    protected $produtoRepository;

    public function __construct(ProdutoRepository $produto)
    {
        $this->produtoRepository = $produto;
    }

    public function find($id, array $with = [])
    {
        return $this->produtoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->produtoRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->produtoRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->produtoRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->produtoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->produtoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

    public function verificaEstoque($id,$qtd)
    {
        $buscaItem = $this->produtoRepository->find($id);
        return $buscaItem->quantidade_estoque < $qtd ? false : true;
    }
}