<?php

namespace App\Console;

use App\Console\Commands\InstallSystem;
use App\Console\Commands\RectifyUserConnections;
use App\Console\Commands\SyncCastingDB;
use App\Console\Commands\SyncOldDB;
use App\Console\Commands\SyncTalktalkDB;
use App\Console\Commands\UninstallSystem;
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
        InstallSystem::class,
        UninstallSystem::class,
        SyncOldDB::class,
        SyncCastingDB::class,
        RectifyUserConnections::class,
        SyncTalktalkDB::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                  ->everyTenMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
