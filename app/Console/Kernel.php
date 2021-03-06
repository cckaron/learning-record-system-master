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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //if schedule not run, php artisan cache:clear will do the trick
        $schedule
            ->command('backup:run')
            ->dailyAt('2:00')
            ->appendOutputTo(storage_path('logs/backup.log'));

        $schedule
            ->command('backup:run --only-db')
            ->hourly()
            ->appendOutputTo(storage_path('logs/backup.log'));

        $schedule
            ->command('backup:run clean')
            ->dailyAt('2:30')
            ->appendOutputTo(storage_path('logs/backup.log'));
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
