<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class create_users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminWeecode = new User();
        $adminWeecode->name = "Admin";
        $adminWeecode->username = 'Admin';
        $adminWeecode->email = 'admin@ceusistemas.com.br';
        $adminWeecode->utilizar_permissoes_nivel_usuario = true;
        $adminWeecode->password = bcrypt('abc@123');
        $adminWeecode->administrador = true;
        $adminWeecode->perfil_id = 1;
        $adminWeecode->grupo_id = 1;
        $adminWeecode->empresa_id = null;
        $adminWeecode->save();
    }
}
