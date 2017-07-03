<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Security\Repositories\RoleRepository;
use Modules\Users\Models\User;
use Modules\Users\Repositories\UsersRepository;

class RectifyUserConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rectify-user-connections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensures no duplicate ids on user connections table. Ensures all users are connected to talkstuff user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var UsersRepository $userRepo
         */
        $userRepo = app(UsersRepository::class);

        /**
         * @var RoleRepository $roleRepo
         */
        $roleRepo = app(RoleRepository::class);
        $basic_role = $roleRepo->getRoleByName('BASIC_USER');

        $talkstuff_user = $userRepo->findByUsername('talkstuff');
        // $this->info($talkstuff_user->friends()->count());

        // todo:: get all users
        $users = $userRepo->getUsers();

        $totalUsers = $users->count();
        $bar = $this->output->createProgressBar($totalUsers);

        $this->alert('syncing user connections');

        /** @var User $user */
        foreach ($users as $user){
            // get unique friends id
            if($user->id !== $talkstuff_user->id) {

                // todo:: connect user with talkstuff
                $userRepo->makeFriend($user->id, $talkstuff_user->id);

            }
            // todo:: attach user to basic role
            $userRepo->attachUserToRole($user, $basic_role->id);

            $bar->advance();
        }

        $bar->finish();

    }
}
