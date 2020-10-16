<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GrupoProdutoRepository;

class ProdutoEcommerceController extends Controller
{
    protected $grupoProdutoRepository;

    public function __construct(GrupoProdutoRepository $grupoProduto)
    {
        $this->middleware('auth');
        $this->grupoProdutoRepository = $grupoProduto;

    }

    public function index(){
        $grupos = $this->grupoProdutoRepository->findBy([
            [
            'inativo','=',0
            ]
        ]);
        return view('ecommerce.produto.index',compact('grupos'));
    }
}
