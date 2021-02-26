<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nome');
            $table->float('valor');
            $table->string('tamanho', 10);
            $table->text('produto_terceiro_id');
            $table->integer('inativo')->default(0);
            $table->integer('grupo_produto_id')->unsigned();
            $table->foreign('grupo_produto_id')->references('id')->on('grupo_produto');
            $table->float('variacao')->nullable();
            $table->float('peso')->nullable();
            $table->integer('quantidade_estoque')->default(0);
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
        Schema::dropIfExists('produto');
    }
}
