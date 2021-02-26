<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_pedido_id')->unsigned();
            $table->foreign('tipo_pedido_id')->references('id')->on('tipo_pedido');
            $table->integer('status_pedido_id')->unsigned();
            $table->foreign('status_pedido_id')->references('id')->on('status_pedido');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('total_pedido')->nullable();
            $table->integer('numero_itens')->nullable();
            $table->date('previsao_entrega')->nullable();
            $table->float('acrescimos')->nullable();
            $table->integer('excluido')->default(0);
            $table->text('link_rastreamento')->nullable();
            $table->text('pedido_terceiro_id')->nullable();
            $table->date('data_envio_pedido')->nullable();
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
        Schema::dropIfExists('pedido');
    }
}
