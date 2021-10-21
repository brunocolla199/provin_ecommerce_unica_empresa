<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    public $table = 'estoque';

    protected $fillable = [
        'id', 'empresa_id', 'produto_id', 'quantidade_estoque', 'valor'
    ];

    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa','id','empresa_id');
    }

    public function produto()
    {
        return $this->hasOne('App\Models\Produto','id','produto_id');
    }
    
}