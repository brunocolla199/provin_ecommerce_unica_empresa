<?php

namespace App\Repositories;

use App\Models\TipoPedido;
use App\Repositories\BaseRepository\BaseRepository;

class TipoPedidoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new TipoPedido();
    }
}
