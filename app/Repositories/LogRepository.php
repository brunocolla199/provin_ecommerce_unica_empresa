<?php

namespace App\Repositories;

use App\Models\Logs;
use App\Repositories\BaseRepository\BaseRepository;

class LogRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Logs();
    }
}
