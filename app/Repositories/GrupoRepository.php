<?php

namespace App\Repositories;

use App\Models\Grupo;
use App\Repositories\BaseRepository\BaseRepository;

class GrupoRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Grupo();
    }
}
