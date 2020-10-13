<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $table = 'produto';

    protected $fillable = [
        'id',
        'nome', 
        'valor',
        'tamanho',
        'produto_terceiro_id',
        'inativo',
        'grupo_id',
        'variacao',
        'peso',
        'quantidade_estoque'
    ];

    public function grupo()
    {
        return $this->hasOne('App\Models\GrupoProduto','id','grupo_id');
    }


}
