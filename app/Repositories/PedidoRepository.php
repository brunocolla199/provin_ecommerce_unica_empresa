<?php

namespace App\Repositories;

use App\Models\Pedido;
use App\Repositories\BaseRepository\BaseRepository;

class PedidoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Pedido();
    }
}
