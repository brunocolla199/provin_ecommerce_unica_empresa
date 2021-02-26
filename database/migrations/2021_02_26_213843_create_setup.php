<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup', function (Blueprint $table) {
            $table->increments('id');
            $table->text('logo_login')->nullable();
            $table->text('logo_sistema')->nullable();
            $table->integer('tempo_liberacao_pedido')->nullable();
            $table->float('valor_adicional_pedido')->nullable();
            $table->text('tamanhos')->nullable();
            $table->integer('tamanho_padrao')->nullable();
            $table->text('caminho_imagen_produto')->nullable();
            $table->text('caminho_importacao_produto')->nullable();
            $table->integer('tempo_expiracao_sessao')->nullable();
            $table->text('grupos')->nullable();
            $table->text('link_sistema_terceiros')->nullable();
            $table->text('usuario_sistema_terceiros')->nullable();
            $table->text('senha_sistema_terceiros')->nullable();
            $table->string('telefone_proprietaria', 50)->nullable();
            $table->string('email_proprietaria', 50)->nullable();
            $table->integer('empresa_default_sistema_terceiros')->nullable();
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
        Schema::dropIfExists('setup');
    }
}
