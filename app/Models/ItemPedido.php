<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    public $table = 'item_pedido';

    protected $fillable = [
        'id',
        'produto_id', 
        'pedido_id', 
        'quantidade', 
        'valor_unitario', 
        'valor_total'
    ];

    public function pedido()
    {
        return $this->hasOne('App\Models\Pedido','id','pedido_id');
    }

    public function produto()
    {
        return $this->hasOne('App\Models\Produto','id','produto_id');
    }

    
}
