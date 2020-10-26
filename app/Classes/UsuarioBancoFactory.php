<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class UsuarioBancoFactory 
{
    private $user;
    private $pass;
    private $schema;

    public function __construct($user)
    {
        $this->user = $user;
        $this->pass = env('DB_PASSWORD', '');
        $this->schema = env('DB_SCHEMA', '');
    }

    public function fabricar()
    {
        try {
            DB::transaction(function () {
                $this->validaUsuario();
                $countUser = DB::table('pg_roles')
                                ->where('rolname', 'LIKE', '%'.$this->user.'%')
                                ->count();
   
                if ($countUser == 0) 
                    $this->criaUsuario();
            });
        } catch (\Throwable $th) {
            Helper::setNotify("Erro ao criar o superuser", 'danger|close-circle');
            return redirect()->back()->withInput();
        }
    }

    private function criaUsuario() : void
    {
        DB::statement("CREATE ROLE $this->user WITH LOGIN NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION VALID UNTIL 'infinity' ");
        DB::statement("GRANT provin_ceu TO $this->user");
        DB::statement("ALTER USER $this->user WITH PASSWORD '".$this->pass."'");
        DB::statement('grant select on all tables in schema '.$this->schema.' to provin_ceu');
    }

    private function validaUsuario() : void
    {
        $usuario = DB::table('users')
            ->where('email', $this->user)
              ->orWhere('username', $this->user)->first();

        $this->user = $usuario->username;   
    }
}