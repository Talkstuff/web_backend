<?php

namespace App\Console\Commands;

use Caffeinated\Modules\Facades\Module;
use Caffeinated\Modules\Modules;
use Illuminate\Console\Command;

class InstallSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var Modules
     */
    private $modules;

    /**
     * Create a new command instance.
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
        //dispatch(new Installer());
        $this->prepareDatabase();

        $this->line('');
        $this->alert('Seeding...');
        foreach ($this->modules->all()->sortBy('refId')->all() as $module){
            \Artisan::call('module:seed', [
                'slug' => str_slug($module['slug']),
            ]);
        }

        \Artisan::call('module:optimize');
    }

    private function prepareDatabase(){
        $modules = $this->modules->all();

        $this->info('Installing system....');
        \DB::statement("SET foreign_key_checks=0");

        $bar = $this->output->createProgressBar(count($modules));

        foreach($modules->sortBy('refId')->all() as $module){
            // migrate module database
            \Artisan::call('module:migrate', [
                'slug' => str_slug($module['slug']),
            ]);

            $bar->advance();
        }

        \DB::statement("SET foreign_key_checks=1");

        $bar->finish();
    }
}