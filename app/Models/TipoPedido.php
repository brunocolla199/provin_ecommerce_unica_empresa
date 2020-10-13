<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPedido extends Model
{
    public $table = 'tipo_pedido';

    protected $fillable = [
        'id', 'nome', 'inativo'
    ];
}
