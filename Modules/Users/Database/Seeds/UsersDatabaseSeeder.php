<?php

namespace Modules\Users\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersDatabaseSeeder extends Seeder
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

        $this->call(UserTableSeeder::class);

        \DB::statement("SET foreign_key_checks=1");
    }
}
