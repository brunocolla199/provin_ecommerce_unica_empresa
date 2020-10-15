<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\{Auth};
use Illuminate\Http\Request;

class ObsPedido extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function montaRequestObs($pedido_id,$descricao,$excluido)
    {
        $createObs = [
            'pedido_id' => $pedido_id,
            'user_id'   => Auth::user()->id,
            'descricao' => $descricao,
            'excluido'  => $excluido
        ];
        return $createObs;

    }
}
