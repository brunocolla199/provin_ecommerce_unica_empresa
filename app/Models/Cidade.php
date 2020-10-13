<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    
    public $table = 'cidade';

    protected $fillable = [
        'id', 'nome', 'estado', 'sigla_estado'
    ];

    /**
     * As empresas que pertencem a cidade.
     */
    public function empresa() {
        return $this->hasMany('App\Models\Empresa');
    }

}
