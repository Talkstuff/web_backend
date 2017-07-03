<?php

namespace Modules\Staff\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Security\Repositories\PermissionRepository;

class StaffPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // todo:: create permissions perculiar to this module

        /**
         * @var PermissionRepository $permissionRepo
         */
        $permissionRepo = app(PermissionRepository::class);

        $adminPermissionsCategory = $permissionRepo->getCategoryByName('Admin Backend');

        $permissions = [
            [
                'name' => 'STAFF__',
                'description' => 'Allow access to staff module'
            ],
            [
                'name' => 'STAFF__CREATE',
                'description' => 'Can create new staff records'
            ],
            [
                'name' => 'STAFF__PROFILE',
                'description' => 'Can view staff profile'
            ],
            [
                'name' => 'STAFF__EDIT',
                'description' => 'Can edit a staff'
            ],
            [
                'name' => 'STAFF__PERMISSIONS',
                'description' => 'Can view (manage) staff permissions'
            ],
        ];

        foreach ($permissions as $permission){
            $permissionRepo->savePermission($adminPermissionsCategory->id, $permission);
        }


    }
}
