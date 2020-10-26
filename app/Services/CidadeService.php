<?php

namespace App\Services;

use App\Repositories\CidadeRepository;
use Illuminate\Http\Request;

class CidadeService
{
    public  $cidadeRepository;

    public function __construct(CidadeRepository $cidade)
    {
        $this->cidadeRepository = $cidade;
    }

    public function find($id, array $with = [])
    {
        return $this->cidadeRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->cidadeRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->cidadeRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->cidadeRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->cidadeRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->cidadeRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }



}