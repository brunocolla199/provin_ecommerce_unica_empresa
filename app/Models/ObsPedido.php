<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObsPedido extends Model
{
    public $table = 'obs_pedido';

    protected $fillable = [
        'pedido_id', 
        'user_id',
        'descricao',
        'excluido'
    ];

    public function pedido()
    {
        return $this->hasOne('App\Models\Pedido','id','pedido_id');
    }

    public function usuario()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
