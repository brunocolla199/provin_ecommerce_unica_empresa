<?php 

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService 
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
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
}