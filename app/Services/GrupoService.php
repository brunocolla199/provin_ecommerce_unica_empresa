<?php

namespace App\Services;

use App\Repositories\GrupoRepository;

class GrupoService
{
    public  $grupoRepository;

    public function __construct()
    {
        $this->grupoRepository = new GrupoRepository();
    }

    public function find($id, array $with = [])
    {
        return $this->grupoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->grupoRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->grupoRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->grupoRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->grupoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->grupoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

}