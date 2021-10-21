<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSetupAddCondicaoPagamentoTerceiro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setup', function (Blueprint $table) {
            $table->text('tipo_documento_default')->nullable(true);
            $table->text('condicao_pagamento_default')->nullable(true);
            $table->integer('perfil_default')->nullable(true);
            $table->integer('grupo_default')->nullable(true);
            $table->text('email_default')->nullable(true)->default('');
            $table->integer('empresa_default')->nullable(true);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setup', function (Blueprint $table) {
            $table->dropColumn('tipo_documento_default');
            $table->dropColumn('condicao_pagamento_default');
            $table->dropColumn('perfil_default');
            $table->dropColumn('grupo_default');
            $table->dropColumn('email_default');
            $table->dropColumn('empresa_default');
        });
    }
}
