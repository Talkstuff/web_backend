<?php

namespace Modules\Security\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Security\Models\Role;
use Modules\Security\Models\RoleCategory;
use Modules\Security\Repositories\RoleRepository;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var RoleRepository $roleRepo
         */
        $roleRepo = app(RoleRepository::class);
        Role::truncate();

        $roles = [
            [
                'name' => 'SUPER_ADMIN_ROLE',
                'description' => 'Super Admin',
            ],
            [
                'name' => 'ADMIN_ROLE',
                'description' => 'Admin',
            ],
            [
                'name' => 'BASIC_USER',
                'description' => 'Basic',
            ],
            [
                'name' => 'STANDARD_USER',
                'description' => 'Standard User',
            ],
            [
                'name' => 'MARKET_PLACE_USER',
                'description' => 'Market Place User',
            ],
            [
                'name' => 'BUSINESS_USER',
                'description' => 'Business User',
            ]
        ];

        foreach ($roles as $role){
            $roleRepo->saveRole($role);
        }
    }
}
