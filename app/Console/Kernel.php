<?php

namespace App\Console;

use Illuminate\Support\Facades\App;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('company:import')->daily();
        $schedule->command('fund:import')->daily();
        $schedule->command('shanghai:import')->daily();
        $schedule->command('lse:import')->daily();
        $schedule->command('japan:import')->daily();
        $schedule->command('euronext:import')->daily();
        $schedule->command('mutualFunds:import')->daily();
        $schedule->command('navbar:import')->daily();
        $schedule->command('tsx:import')->daily();
        //todo: verify that it could be run daily
        $schedule->command('navbar:import')->daily();
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
