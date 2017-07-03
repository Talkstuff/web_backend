<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Casting\Repositories\CastingRepository;

class SyncCastingDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-casting-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @param CastingRepository $castingRepository
     * @return mixed
     */
    public function handle(CastingRepository $castingRepository)
    {
        $this->alert('Migrating to talkstuff database...');

        $usersSyncedToTS = $castingRepository->syncToTalkstuffDB();
        $this->line(count($usersSyncedToTS) . " synced to talkstuff DB");
        $this->line('');

        $this->alert('Migrating to wordpress database...');

        $usersSyncedToWP = $castingRepository->syncToWordpressDB();
        $this->line(count($usersSyncedToWP) . " synced to wordpress DB");
        $this->line('');
    }
}
