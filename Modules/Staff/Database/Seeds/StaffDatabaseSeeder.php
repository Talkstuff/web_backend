<?php

namespace Modules\Staff\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class StaffDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("SET foreign_key_checks=0");
        Model::unguard();

        $this->call(StaffsDataSeeder::class);
        $this->call(StaffPermissionSeeder::class);

        \DB::statement("SET foreign_key_checks=1");
    }
}
