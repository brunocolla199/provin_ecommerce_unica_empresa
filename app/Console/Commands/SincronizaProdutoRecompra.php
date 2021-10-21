<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ConfiguracaoController;

class SincronizaProdutoRecompra extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sincronizaProdutoRecompra';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para sincronizar os produtos para recompra';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $configuracaoController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConfiguracaoController $configuracaoController)
    {
        parent::__construct();
        $this->configuracaoController = $configuracaoController;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->configuracaoController->importWebService();
    }
}
