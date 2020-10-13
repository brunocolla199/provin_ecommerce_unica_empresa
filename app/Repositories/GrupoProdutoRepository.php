<?php

namespace App\Repositories;

use App\Models\GrupoProduto;
use App\Repositories\BaseRepository\BaseRepository;

class GrupoProdutoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new GrupoProduto();
    }
}
