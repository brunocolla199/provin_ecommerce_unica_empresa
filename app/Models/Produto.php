<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $table = 'produto';

    protected $fillable = [
        'nome', 
        'valor',
        'tamanho',
        'produto_terceiro',
        'inativo',
        'grupo_produto_id',
        'variacao',
        'peso',
        'quantidade_estoque',
        'produto_terceiro_id',
        'existe_foto'
    ];

    public function grupo()
    {
        return $this->hasOne('App\Models\GrupoProduto','id','grupo_produto_id');
    }


}
