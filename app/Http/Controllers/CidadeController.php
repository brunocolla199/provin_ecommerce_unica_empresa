<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB};
use App\Repositories\CidadeRepository;

class CidadeController extends Controller
{
    protected $cidadeRepository;

    public function __construct(CidadeRepository $cidade)
    {
        $this->middleware('auth');
        $this->cidadeRepository = $cidade;
    }

    public function index() {
        $cidades = $this->cidadeRepository->findBy(
            [],
            [],
            [['nome','asc']]
        );
        
        return view('admin.cidade.index', compact('cidades'));
    }

    public function create()
    {
        $estados = $this->cidadeRepository->findBy(
            [],
            [],
            [['sigla_estado','asc']],
            [['sigla_estado'],['estado']],
            null,
            null,
            ['sigla_estado','estado']
        );
        return view('admin.cidade.create', compact('estados'));
    }


    public function store(Request $_request) 
    {
        try {
            if (!$this->validator($_request)) {
                return redirect()->back()->withInput();
            }
           
            DB::transaction(function () use ($_request) {
                $create = self::montaRequest($_request);
                $this->cidadeRepository->create($create); 
            });
            Helper::setNotify('Nova cidade criada com sucesso!', 'success|check-circle');
            return redirect()->route('cidade');
        } catch (\Throwable $th) {

            Helper::setNotify("Erro ao criar a cidade", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }


    public function edit($_id)
    {
        $estados = $this->cidadeRepository->findBy(
            [],
            [],
            [['sigla_estado','asc']],
            [['sigla_estado'],['estado']],
            null,
            null,
            ['sigla_estado','estado']
        );
        $cidade = $this->cidadeRepository->find($_id);
        return view('admin.cidade.update', compact('cidade', 'estados'));
    }

    public function update(Request $request)
    {
        if(!$this->validator($request)){
            return redirect()->back()->withInput();
        }

        $id = $request->get('idCidade');
        
        $update = self::montaRequest($request);
       
        try {
            DB::transaction(function () use ($update, $id) {
                $this->cidadeRepository->update(
                    $update,
                    $id);
            });
            Helper::setNotify('Cidade atualizado com sucesso!', 'success|check-circle');
            return redirect()->route('cidade');
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao atualizar a cidade", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'      => 'required|string|max:100|min:3|unique:cidade',
            'estado'    => 'required|string|max:2|min:2'
        ]);

        if ($validator->fails()) {
            Helper::setNotify($validator->messages()->first(), 'danger|close-circle');
            return false;
        }
        return true;
    }

    public function montaRequest(Request $request)
    {
        $buscaNomeEstado = $this->cidadeRepository->findBy([['sigla_estado', '=', $request->estado]])->first();
        return [
            'nome'   => $request->nome,
            'sigla_estado' => $request->estado,
            'estado' => $buscaNomeEstado->estado
        ];
    }
}
