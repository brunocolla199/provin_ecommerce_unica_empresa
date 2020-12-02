<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public $table = 'pedido';

    protected $fillable = [ 
        'tipo_pedido_id', 
        'status_pedido_id',
        'user_id',
        'total_pedido',
        'numero_itens',
        'previsao_entrega',
        'excluido',
        'acrescimos',
        'link_rastreamento',
        'pedido_terceiro_id',
        'data_envio_pedido'
    ];

    public function tipoPedido()
    {
        return $this->hasOne('App\Models\TipoPedido','id','tipo_pedido_id');
    }

    public function statusPedido()
    {
        return $this->hasOne('App\Models\StatusPedido','id','status_pedido_id');
    }


    public function usuario()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function itens()
    {
        return $this->hasMany('App\Models\ItemPedido','pedido_id','id');
    }

    
}
