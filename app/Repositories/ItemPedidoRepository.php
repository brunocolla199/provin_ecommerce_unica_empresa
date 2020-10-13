<?php

namespace App\Repositories;

use App\Models\ItemPedido;
use App\Repositories\BaseRepository\BaseRepository;

class ItemPedidoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new ItemPedido();
    }
}
