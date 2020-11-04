<?php

namespace App\Repositories;

use App\Models\Estoque;
use App\Repositories\BaseRepository\BaseRepository;

class EstoqueRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Estoque();
    }
}
