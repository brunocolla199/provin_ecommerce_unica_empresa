<?php

namespace App\Repositories;

use App\Models\Setup;
use App\Repositories\BaseRepository\BaseRepository;

class SetupRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Setup();
    }
}
