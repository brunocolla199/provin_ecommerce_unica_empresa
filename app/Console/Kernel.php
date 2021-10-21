<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\SincronizaEstoqueFranquias',
        'App\Console\Commands\SincronizaProdutoRecompra',
        'App\Console\Commands\SincronizarFotos',
        'App\Console\Commands\SincronizaEstoqueParcialFranquias'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        //$schedule->command('sincronizaProdutoRecompra')->dailyAt('00:10')->runInBackground();
        //$schedule->command('sincronizarFotos')->dailyAt('1:00')->runInBackground();
        //$schedule->command('sincronizaEstoqueFranquias')->dailyAt('00:30')->runInBackground();
        //$schedule->command('sincronizaEstoqueParcialFranquias')->dailyAt('12:00')->runInBackground();
        //$schedule->command('sincronizaEstoqueParcialFranquias')->dailyAt('18:00')->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
