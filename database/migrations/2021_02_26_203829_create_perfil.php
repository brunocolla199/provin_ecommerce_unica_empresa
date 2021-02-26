<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nome');
            $table->integer('inativo')->default(0);
            $table->integer('eco_listar_pedido')->default(0);
            $table->integer('eco_detalhes_pedido')->default(0);
            $table->integer('eco_enviar_pedido_normal')->default(0);
            $table->integer('eco_enviar_pedido_expresso')->default(0);
            $table->integer('admin_controle_geral')->default(0);
            $table->integer('area_admin')->default(0);
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil');
    }
}
