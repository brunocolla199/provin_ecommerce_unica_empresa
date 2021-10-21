<?php

namespace App\Console\Commands;
use App\Http\Controllers\ConfiguracaoController;
use Illuminate\Console\Command;

class SincronizarFotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sincronizarFotos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command para sincronizar fotos';

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
        $this->configuracaoController->buscaFotos();
    }
}
