<?php

namespace App\Repositories;

use App\Models\Produto;
use App\Repositories\BaseRepository\BaseRepository;

class ProdutoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Produto();
    }
}
