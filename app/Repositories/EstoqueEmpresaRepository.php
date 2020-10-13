<?php

namespace App\Repositories;

use App\Models\EstoqueEmpresa;
use App\Repositories\BaseRepository\BaseRepository;

class EstoqueEmpresaRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new EstoqueEmpresa();
    }
}
