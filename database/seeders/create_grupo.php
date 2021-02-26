<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\GrupoRepository;

class create_grupo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupoRepository = new GrupoRepository();

        $grupoRepository->create([
            'nome'      => 'Administradores',
            'descricao' => 'Grupo de Administradores'
        ]);

        $grupoRepository->create([
            'nome'      => 'Franquias',
            'descricao' => 'Grupo de Franquias'
        ]);
    }
}
