<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    
    public $table = 'grupo';

    protected $fillable = [
        'id', 'nome', 'descricao','inativo'
    ];

    
    /**
     * Os usuários que pertencem ao grupo.
     */
    public function users() {
        return $this->hasMany('App\Models\User');
    }

}
