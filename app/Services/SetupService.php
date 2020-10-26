<?php 

namespace App\Services;

use App\Repositories\SetupRepository;

class SetupService 
{
    protected $setupRepository;

    public function __construct(SetupRepository $setup)
    {
        $this->setupRepository = $setup;
    }

    public function find($id, array $with = [])
    {
        return $this->setupRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->setupRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->setupRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->setupRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->setupRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->setupRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }
}