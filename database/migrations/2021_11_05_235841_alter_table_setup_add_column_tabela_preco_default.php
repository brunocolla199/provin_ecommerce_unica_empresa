<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSetupAddColumnTabelaPrecoDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setup', function (Blueprint $table) {
            $table->integer('tabela_preco_default')->nullable(true);            
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
            $table->dropColumn('tabela_preco_default');
        });
    }
}
