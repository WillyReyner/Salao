<?php

namespace App\Console;

use App\CustomLog\EditalLog\CleanEditalActivitylogCommand;
use App\CustomLog\CursoLog\CleanCursoActivitylogCommand;
use App\CustomLog\InscricaoLog\CleanInscricaoActivitylogCommand;
use App\CustomLog\TurmaLog\CleanTurmaActivitylogCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CleanEditalActivitylogCommand::class,
        CleanCursoActivitylogCommand::class,
        CleanInscricaoActivitylogCommand::class,
        CleanTurmaActivitylogCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('editais:verificar')->daily(); // Executar diariamente
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
