<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SetupService;
use App\Classes\Helper;
use Illuminate\Support\Facades\{Validator, DB};
use function GuzzleHttp\json_encode;
use App\Services\GrupoProdutoService;
use App\Services\ProdutoService;
use App\Services\EmpresaService;
use App\Classes\WonderServices;
use App\Services\EstoqueService;
use App\Services\PerfilService;
use App\Services\GrupoService;
use App\Models\Empresa;

class ConfiguracaoController extends Controller
{

    protected $empresaService;
    protected $estoqueService;
    protected $wonderService;

   
}
