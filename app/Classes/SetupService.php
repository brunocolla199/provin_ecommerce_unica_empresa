<?php

namespace App\Classes;

use App\Repositories\SetupRepository;

class SetupService 
{
    private $setupRepository;

    public function __construct() {
        $this->setupRepository = new SetupRepository();
    }
    
    public function buscar($id) 
    {
        $setup = $this->setupRepository->find($id, []);
        return $setup;
    }

    public function tamanhosToString($tamanhos) 
    {
        $tamanhosStr = "";
    
        foreach ($tamanhos as $tamanho) 
        {
            if ($tamanhosStr == "") 
            {
                $tamanhosStr = $tamanho;
            }
            else 
            {
                $tamanhosStr = $tamanhosStr." , ".$tamanho;
            }
        }

        return $tamanhosStr;
    }
}