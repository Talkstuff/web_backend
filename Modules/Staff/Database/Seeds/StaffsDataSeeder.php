<?php

namespace Modules\Staff\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Security\Repositories\RoleRepository;
use Modules\Staff\Models\Staff;
use Modules\Staff\Repositories\StaffRepository;


class StaffsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::truncate();
        /**
         * @var StaffRepository $staffRepo
         */
        $staffRepo = app(StaffRepository::class);

        /**
         * @var RoleRepository $roleRepo
         */
        $roleRepo = app(RoleRepository::class);

        $staffs = [
            [
                'firstName' => 'Dennis',
                'lastName' => 'O',
                'username' => 'dennisohere',
                'password' => 'secret',
                'email' => 'dennisohere@talkstuff.com',
                'phone' => '08060935051',
                'roleIds' => [$roleRepo->getRoleByName('SUPER_ADMIN_ROLE')->id],
                'active' => true
            ],
            [
                'firstName' => 'Cassy',
                'lastName' => 'Olaleye',
                'username' => 'cassy',
                'password' => 'cassy123',
                'email' => 'cassy@talkstuff.com',
                'phone' => '08060935051',
                'roleIds' => [$roleRepo->getRoleByName('SUPER_ADMIN_ROLE')->id],
                'active' => true
            ]
        ];

        foreach ($staffs as $staff){
            $staffRepo->saveStaff($staff);
        }
    }
}
