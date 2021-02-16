<?php 

namespace App\Services;

use App\Repositories\TipoPedidoRepository;

class TipoPedidoService 
{
    protected $tipoPedidoRepository;

    public function __construct()
    {
        $this->tipoPedidoRepository = new TipoPedidoRepository;
    }

    public function find($id, array $with = [])
    {
        return $this->tipoPedidoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->tipoPedidoRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->tipoPedidoRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->tipoPedidoRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->tipoPedidoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->tipoPedidoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }
}