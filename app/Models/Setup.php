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
        'tamanhos',
        'tamanho_padrao',
        'tempo_expiracao_sessao',
        'caminho_imagen_produto',
        'caminho_importacao_produto',
        'grupos',
        'link_sistema_terceiros',
        'usuario_sistema_terceiros',
        'senha_sistema_terceiros',
        'telefone_proprietaria',
        'email_proprietaria'
    ];
}
