<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePerfilAddColumnEcoListarEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perfil', function (Blueprint $table) {
            $table->integer('eco_listar_estoque')->default(0);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perfil', function (Blueprint $table) {
            $table->dropColumn('eco_listar_estoque');
        });
    }
}
