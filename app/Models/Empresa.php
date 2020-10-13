<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    
    public $table = 'empresa';

    protected $fillable = [
        'id', 
        'razao_social', 
        'nome_fantasia', 
        'empresa_terceiro_id', 
        'tipo_pessoa', 
        'cpf_cnpj', 
        'telefone', 
        'email',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'inativo',
        'cidade_id',
        'cep'
    ];

    
    public function cidade()
    {
        return $this->hasOne('App\Models\Cidade','id','cidade_id');
    }

    public function produto()
    {
        return $this->belongsToMany('App\Models\Produto');
    }

    

    
}
