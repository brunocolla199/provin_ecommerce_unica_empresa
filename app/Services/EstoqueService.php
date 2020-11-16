<?php

namespace App\Services;

use App\Repositories\EstoqueRepository;

class EstoqueService
{
    public  $estoqueRepository;

    public function __construct(EstoqueRepository $estoque)
    {
        $this->estoqueRepository = $estoque;
    }

    public function find($id, array $with = [])
    {
        return $this->estoqueRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->estoqueRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->estoqueRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->estoqueRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->estoqueRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->estoqueRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

    

}