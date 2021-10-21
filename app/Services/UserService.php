<?php 

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SetupRepository;

class UserService 
{
    protected $userRepository;
    protected $setupRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->setupRepository = new SetupRepository();
    }

    public function find($id, array $with = [])
    {
        return $this->userRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->userRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->userRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->userRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->userRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

    public function buscaUsuariosMesmaEmpresa()
    {
        $empresa = Auth::user()->empresa_id;
        $buscaUsuario = self::findBy(
            [
                ['empresa_id','=',$empresa]
            ]
        );

        $usuariosIn = [];
        foreach ($buscaUsuario as $key => $value) {
            array_push($usuariosIn,$value->id);
        }
        return $usuariosIn;
    }

    public function getEmpresa()
    {
        $buscaSetup = $this->setupRepository->find(1);
        $empresaService = new EmpresaService();
        $buscaEmpresa = $empresaService->findOneBy(
            [
                ['empresa_terceiro_id', '=', $buscaSetup->empresa_default_sistema_terceiros]
            ]
        );

        $empresaId = $buscaEmpresa->id ?? null;
        if(Auth::check() && !empty(Auth::user()->empresa_id)){
            $empresaId = Auth::user()->empresa_id;
        }
        return $empresaId;
    }
}