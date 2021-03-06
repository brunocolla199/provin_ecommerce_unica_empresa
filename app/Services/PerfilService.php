<?php 

namespace App\Services;

use App\Repositories\PerfilRepository;

class PerfilService 
{
    protected $perfilRepository;

    public function __construct()
    {
        $this->perfilRepository = new PerfilRepository();
    }

    public function find($id, array $with = [])
    {
        return $this->perfilRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->perfilRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->perfilRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->perfilRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->perfilRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->perfilRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }
}