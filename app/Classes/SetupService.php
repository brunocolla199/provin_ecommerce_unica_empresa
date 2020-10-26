<?php

namespace App\Classes;

use App\Repositories\SetupRepository;

class SetupService 
{
    private $setupRepository;

    public function __construct() {
        $this->setupRepository = new SetupRepository();
    }
    
    
}