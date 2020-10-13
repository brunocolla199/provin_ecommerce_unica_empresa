<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    public $table = 'perfil';

    protected $fillable = [
        'id',
        'nome',
        'inativo',
        'observacao',
        'eco_listar_pedido',
        'eco_detalhes_pedido',
        'eco_enviar_pedido_normal',
        'eco_enviar_pedido_expresso',
        'admin_controle_geral',
        'area_admin'
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

}
