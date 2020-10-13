<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkLogin()
    {
        
        if(!Auth::check()){
            //Se não estiver logado direciona para o Login
            return redirect()->route('login');
        }
        
        if(Auth::user()->perfil->admin_controle_geral == 1){
            
            //Se for adm
            return redirect()->guest('admin/home');
        }else{
            
            //Se não for adm
           return redirect()->guest('ecommerce/home');

        } 
    }
}
