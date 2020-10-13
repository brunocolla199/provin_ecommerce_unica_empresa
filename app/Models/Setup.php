<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    
    public $table = 'setup';

    protected $fillable = [
        'id', 
        'logo_login', 
        'logo_sistema', 
        'tempo_liberacao_pedido',
        'valor_adicional_pedido',
        'tamanhos_aneis',
        'tamanho_padrao_anel',
        'tempo_expiracao_sessao',
        'caminho_imagen_produto',
        'caminho_importacao_produto'
    ];
}
