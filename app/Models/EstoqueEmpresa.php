<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueEmpresa extends Model
{
    public $table = 'estoque_empresa';

    protected $fillable = [
        'id', 'empresa_id', 'produto_id', 'estoque'
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
