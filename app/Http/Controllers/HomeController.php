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
        //return redirect()->route('ecommerce.produto');
        
        if(!Auth::check()){
            //Se não estiver logado direciona para o Login
            return redirect()->guest('ecommerce/produto');
        }
        
        if(!empty(Auth::user()->perfil) && Auth::user()->perfil->area_admin == 1){
            
            //Se for adm
            return redirect()->guest('admin/home');
        }else{
            //Se não for adm
           return redirect()->guest('ecommerce/produto');

        } 
        
    }
}
