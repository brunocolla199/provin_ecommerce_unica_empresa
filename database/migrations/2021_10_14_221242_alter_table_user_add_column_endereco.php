<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddColumnEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tipo_pessoa',1)->nullable();
            $table->string('cpf_cnpj',18)->nullable();
            $table->string('telefone',15)->nullable();
            $table->text('endereco')->nullable();
            $table->text('numero')->nullable();
            $table->text('complemento')->nullable();
            $table->text('bairro')->nullable();
            $table->string('cep', 20)->nullable();
            $table->text('rg_inscricao_estadual')->nullable();
            $table->integer('cidade_id')->unsigned()->nullable(true);
            $table->foreign('cidade_id')->references('id')->on('cidade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipo_pessoa');
            $table->dropColumn('cpf_cnpj');
            $table->dropColumn('telefone');
            $table->dropColumn('endereco');
            $table->dropColumn('numero');
            $table->dropColumn('complemento');
            $table->dropColumn('bairro');
            $table->dropColumn('cep');
            $table->dropColumn('rg_inscricao_estadual');
            $table->dropForeign('users_cidade_id_foreign');
            $table->dropColumn('cidade_id');
        });
    }
}
