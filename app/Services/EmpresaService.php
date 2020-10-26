<?php

namespace App\Services;

use App\Repositories\EmpresaRepository;

class EmpresaService
{
    public  $empresaRepository;

    public function __construct(EmpresaRepository $empresa)
    {
        $this->empresaRepository = $empresa;
    }

    public function find($id, array $with = [])
    {
        return $this->empresaRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->empresaRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->empresaRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->empresaRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->empresaRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->empresaRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

}