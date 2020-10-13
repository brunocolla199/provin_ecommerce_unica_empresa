<?php

namespace App\Repositories;

use App\Models\StatusPedido;
use App\Repositories\BaseRepository\BaseRepository;

class StatusPedidoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new StatusPedido();
    }
}
