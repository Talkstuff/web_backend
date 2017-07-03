<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Talktalk\Repositories\TalktalkRepository;

class SyncTalktalkDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-talktalk-db';

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
     * @param TalktalkRepository $talktalkRepository
     * @return mixed
     */
    public function handle(TalktalkRepository $talktalkRepository)
    {
        $this->alert('Migrating to wordpress database...');

        $usersSyncedToWP = $talktalkRepository->syncToWordpressDB();
        $this->line(count($usersSyncedToWP) . " synced to wordpress DB");

    }
}
