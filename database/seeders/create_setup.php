<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setup;

class create_setup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setup = new Setup();
        $setup->logo_login = '';
        $setup->logo_sistema = '';
        $setup->tempo_liberacao_pedido = '15';
        $setup->valor_adicional_pedido = '25';
        $setup->tamanhos = '["14","16","18","20","22","24","26"]';
        $setup->tamanho_padrao = '24';
        $setup->caminho_imagen_produto = 'img/produtos/';
        $setup->grupos = '["31"]';
        $setup->link_sistema_terceiros = 'http://10.2.2.10:8180';
        $setup->usuario_sistema_terceiros = 'WEBMASTER';
        $setup->senha_sistema_terceiros = 'WEB';
        $setup->telefone_proprietaria = '(54) 9999-99999';
        $setup->email_proprietaria = 'teste@teste2.com.br';
        $setup->empresa_default_sistema_terceiros = '10';
        $setup->save();
    }
}
