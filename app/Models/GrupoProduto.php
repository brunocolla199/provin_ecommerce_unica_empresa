<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoProduto extends Model
{
    public $table = 'grupo_produto';

    protected $fillable = [
        'id', 'nome', 'inativo'
    ];

    /**
     * Grupo Produto tem muitos produto.
     */
    public function produto() {
        return $this->hasMany('App\Models\Produto');
    }
}
