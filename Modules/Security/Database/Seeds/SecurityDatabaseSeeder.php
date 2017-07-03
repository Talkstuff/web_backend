<?php

namespace Modules\Security\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SecurityDatabaseSeeder extends Seeder
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

        $this->call(RolesSeeder::class);
        $this->call(PermissionSeeder::class);

        \DB::statement("SET foreign_key_checks=1");
    }
}
