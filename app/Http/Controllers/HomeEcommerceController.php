<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeEcommerceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        return view('ecommerce.home.index');
    }
}
