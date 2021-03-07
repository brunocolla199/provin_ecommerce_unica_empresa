<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Request;

use App\Services\PedidoService;
use App\Services\ItemPedidoService;
use App\Services\StatusPedidoService;
use App\Services\ObsPedidoService;
use App\Services\SetupService;

class LoginCadastroController extends Controller
{
    public function __construct()
    {
        
        
    }

    public function index(){
        
        return view('ecommerce.login-cadastro.index');

    }


    

   
    

    

    

    

    
}
