<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 14/06/2017
 * Time: 04:04 PM
 */

namespace Modules\Talktalk\Repositories;


use Carbon\Carbon;
use Modules\Casting\Models\Cast;
use Modules\Casting\Models\CastCategory;
use Modules\Casting\Models\CastingUsers;
use Modules\Talktalk\Models\WpUsers;
use Modules\Users\Models\User;

class TalktalkRepository
{
    /**
     * @var WpUsers
     */
    private $wpUsers;


    /**
     * CastingRepository constructor.
     * @param WpUsers $wpUsers
     * @internal param CastingUsers $castingUsers
     */
    public function __construct(WpUsers $wpUsers)
    {
        $this->wpUsers = $wpUsers;
    }

    public function syncToWordpressDB()
    {
        $ts_users = User::all();

        $migrated = [];

        foreach ($ts_users as $user){
            $wp_user = $this->toWordpress($user);

            if($wp_user) $migrated[] = $wp_user;
        }

        return $migrated;
    }

    public function toWordpress(User $user)
    {
        $wp_user = WpUsers::firstOrNew([
            'user_login' => $user->username,
        ]);

        $wp_user->fill([
            'user_nicename' => $user->getDisplayName(),
            'user_registered' => date('Y-m-d'),
            'user_pass' => $user->password,
            'display_name' => $user->getDisplayName(),
            'user_email' => $user->email
        ]);

        $wp_user->save();

        return $wp_user;
    }
}