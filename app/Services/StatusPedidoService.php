<?php 

namespace App\Services;

use App\Repositories\StatusPedidoRepository;

class StatusPedidoService 
{
    protected $statusPedidoRepository;

    public function __construct(StatusPedidoRepository $statusPedido)
    {
        $this->statusPedidoRepository = $statusPedido;
    }

    public function find($id, array $with = [])
    {
        return $this->statusPedidoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->statusPedidoRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->statusPedidoRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->statusPedidoRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->statusPedidoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->statusPedidoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }
}