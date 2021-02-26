<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\PerfilRepository;

class create_perfil extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfilRepository = new PerfilRepository();

        $perfilRepository->create([
            'nome' => 'Administrador',
            'admin_controle_geral' => 1,
            'area_admin' => 1
        ]);
    }
}
