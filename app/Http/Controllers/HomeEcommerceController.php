<?php

namespace App\Http\Controllers;

use App\Services\SetupService;

class HomeEcommerceController extends Controller
{
    protected $pedidoService;
    
    public function __construct()
    {
        $this->middleware('auth');
        
        
        
    }

    public function index()
    {
        return view('ecommerce.home.index',
            [
              
            ]
        );
    }
}
