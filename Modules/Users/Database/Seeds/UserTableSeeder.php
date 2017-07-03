<?php

namespace Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Posts\Models\Post;
use Modules\Users\Models\Group;
use Modules\Users\Models\User;
use Modules\Users\Repositories\UsersRepository;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\Users\Models\User::truncate();
        \Modules\Users\Models\Group::truncate();

        $startUpGroup = Group::firstOrCreate([
            'name' => 'iStars',
            'reserved' => true
        ]);

        $user_ids = [];

        factory(\Modules\Users\Models\User::class, 10)->create()->each(function ($u) use($startUpGroup, &$user_ids) {
            /**
             * @var User $u
             */
            $u->groupsBelongingTo()->attach($startUpGroup->id);
            $u->posts()->create([
                'content' => 'Testing post seeds from ' . $u->fullName()
            ]);
            $user_ids[] = $u->id;
        });

        $dennis = factory(\Modules\Users\Models\User::class)->create([
            'first_name' => 'Dee',
            'last_name' => 'Dan',
            'phone' => '08060935051',
            'birth_date' => '1988-01-25',
            'username' => 'dennisohere',
            'email' => 'dennisohere@live.com',
            'registered_date' => \Carbon\Carbon::now()->format('Y-m-d'),
            'password' => bcrypt('secret'),
            'remember_token' => str_random(10),
        ]);

        /**
         * @var UsersRepository $userRepo
         */
        $userRepo = app(UsersRepository::class);

        foreach ($user_ids as $friendId) {
            $userRepo->makeFriend($dennis->id, $friendId);
        }
    }
}
