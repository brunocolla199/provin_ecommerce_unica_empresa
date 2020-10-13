<?php

namespace App\Repositories;

use App\Models\ObsPedido;
use App\Repositories\BaseRepository\BaseRepository;

class ObsPedidoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new ObsPedido();
    }
}
