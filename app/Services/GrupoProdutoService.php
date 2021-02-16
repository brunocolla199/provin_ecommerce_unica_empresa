<?php

namespace App\Services;

use App\Repositories\GrupoProdutoRepository;

class GrupoProdutoService
{
    public  $grupoProdutoRepository;

    public function __construct()
    {
        $this->grupoProdutoRepository = new GrupoProdutoRepository();
    }

    public function find($id, array $with = [])
    {
        return $this->grupoProdutoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->grupoProdutoRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->grupoProdutoRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->grupoProdutoRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->grupoProdutoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->grupoProdutoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

}