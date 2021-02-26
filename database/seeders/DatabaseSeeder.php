<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\create_cidade::class);
        $this->call(\Database\Seeders\create_setup::class);
        $this->call(\Database\Seeders\create_grupo::class);
        $this->call(\Database\Seeders\create_perfil::class);
        $this->call(\Database\Seeders\create_users::class);
    }
}
