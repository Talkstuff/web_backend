<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 14/06/2017
 * Time: 04:04 PM
 */

namespace Modules\Casting\Repositories;


use Carbon\Carbon;
use Modules\Casting\Models\Cast;
use Modules\Casting\Models\CastCategory;
use Modules\Casting\Models\CastingUsers;
use Modules\Users\Models\User;

class CastingRepository
{
    /**
     * @var Cast
     */
    private $cast;
    /**
     * @var CastCategory
     */
    private $category;
    /**
     * @var CastingUsers
     */
    private $castingUsers;


    /**
     * CastingRepository constructor.
     * @param Cast $cast
     * @param CastCategory $category
     * @param CastingUsers $castingUsers
     */
    public function __construct(Cast $cast, CastCategory $category, CastingUsers $castingUsers)
    {
        $this->cast = $cast;
        $this->category = $category;
        $this->castingUsers = $castingUsers;
    }

    /**
     * @param $user_id
     * @param array $data
     * @return Cast
     */
    public function saveCast($user_id, array $data)
    {
        $cast = $this->cast->fill([
            'name' => $data['fullName'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'date_of_birth' => $data['dateOfBirth'],
            'country' => $data['country'],
            'height' => $data['height'],
            'waist_size' => $data['waistSize'],
            'chest_size' => $data['chestSize'],
            'shoe_size' => $data['shoeSize'],
            'hair_colour' => $data['hairColour'],
            'eye_colour' => $data['eyeColour'],
            'category_id' => $data['category_id'],
            'image_attachments' => json_encode($data['imageAttachments']),
            'head_shot_image' => json_encode($data['headShotImage']),
            'user_id' => $user_id
        ]);

        $cast->save();

        return $cast;
    }

    public function fetchWordpressCastingUsers()
    {
        return $this->castingUsers->all();

    }

    public function syncToTalkstuffDB() {
        // todo:: fetch all users in wordpress casting db
        $castingUsers = $this->fetchWordpressCastingUsers();

        $migrated = [];

        foreach($castingUsers as $user) {

            $ts_user = $this->toTalkstuff($user);

            if($ts_user) $migrated[] = $ts_user;
        }

        return $migrated;
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

    public function toTalkstuff(CastingUsers $user){
        $ts_user = User::firstOrNew([
            'username' => $user->user_login,
        ]);

        $ts_user->fill([
            'display_name' => $user->user_nicename,
            'registered_date' => date('Y-m-d'),
            'password' => $user->user_pass,
            'email' => $user->user_email,
        ]);

        $ts_user->save();

        return $ts_user;
    }

    public function toWordpress(User $user)
    {
        $wp_user = CastingUsers::firstOrNew([
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