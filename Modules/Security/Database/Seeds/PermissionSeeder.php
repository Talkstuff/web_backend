<?php

namespace Modules\Security\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Security\Models\Permission;
use Modules\Security\Models\PermissionCategory;
use Modules\Security\Repositories\PermissionRepository;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();



    }
}
