<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    
    protected $fillable = [
        'id', 'idArea', 'idRegistro', 'idDocumento', 'acao', 'referencia', 'idUsuario', 'data', 'nomeProcesso', 'descricao', 'complemento', 'valor',
    ];

    protected $dates = [
        'data'
    ];

}
