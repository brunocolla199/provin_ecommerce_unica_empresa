<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->text('razao_social');
            $table->string('cpf_cnpj',18);
            $table->string('telefone',15);
            $table->text('nome_fantasia')->nullable();
            $table->string('tipo_pessoa',1)->nullable();
            $table->integer('empresa_terceiro_id')->nullable();
            $table->text('endereco')->nullable();
            $table->text('numero')->nullable();
            $table->text('complemento')->nullable();
            $table->text('bairro')->nullable();
            $table->integer('inativo')->default(0);
            $table->text('email')->nullable();
            $table->string('cep', 20)->nullable();
            $table->text('usuario_sistema_terceiro')->nullable();
            $table->text('senha_sistema_terceiro')->nullable();
            $table->text('rg_inscricao_estadual')->nullable();
            $table->integer('cidade_id')->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidade');
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
        Schema::dropIfExists('empresa');
    }
}
