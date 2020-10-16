<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPedido extends Model
{
    public $table = 'status_pedido';

    protected $fillable = [
        'id', 'nome', 'inativo', 'nome_icone'
    ];
}
