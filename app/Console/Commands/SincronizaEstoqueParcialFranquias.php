<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ConfiguracaoController;

class SincronizaEstoqueParcialFranquias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sincronizaEstoqueParcialFranquias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para sincronizar o estoque parcial das franquias';

    protected $configuracaoController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "passou";
        //$configuracaoController =  new ConfiguracaoController();
        //$configuracaoController->atualizarEstoqueParcial();
    }
}
