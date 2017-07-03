<?php

namespace App\Console\Commands;

use Caffeinated\Modules\Modules;
use Illuminate\Console\Command;

class UninstallSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstalls the system with the database';
    /**
     * @var Modules
     */
    private $modules;

    /**
     * Create a new command instance.
     *
     * @param Modules $modules
     */
    public function __construct(Modules $modules)
    {
        parent::__construct();
        $this->modules = $modules;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepareDatabase();

        \Artisan::call('module:optimize');
    }

    private function prepareDatabase(){
        $modules = $this->modules->all();

        $this->info('Uninstalling system....');
        \DB::statement("SET foreign_key_checks=0");

        $bar = $this->output->createProgressBar(count($modules));

        foreach($modules->sortBy('refId')->reverse()->all() as $module){
            // migrate module database
            \Artisan::call('module:migrate:reset', [
                'slug' => str_slug($module['slug']),
            ]);

            $bar->advance();
        }

        \DB::statement("SET foreign_key_checks=1");

        $bar->finish();
    }
}
