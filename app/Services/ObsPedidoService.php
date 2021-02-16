<?php

namespace App\Services;
use Illuminate\Support\Facades\{Auth};

use App\Repositories\ObsPedidoRepository;

class ObsPedidoService
{
    public  $obsRepository;

    public function __construct()
    {
        $this->obsRepository = new ObsPedidoRepository();
    }

    public function find($id, array $with = [])
    {
        return $this->obsRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->obsRepository->findAll($with,$orderBy);
    }

    public function create($id,$descricao,$excluido)
    {
        $requestObs = self::montaRequestObs($id,$descricao,$excluido);
        return $this->obsRepository->create($requestObs);
    }

    public function update(array $data, $id)
    {
        return $this->obsRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->obsRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->obsRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

    public function montaRequestObs($pedido_id,$descricao,$excluido)
    {
        $createObs = [
            'pedido_id' => $pedido_id,
            'user_id'   => Auth::user()->id,
            'descricao' => $descricao,
            'excluido'  => $excluido
        ];
        return $createObs;

    }

}