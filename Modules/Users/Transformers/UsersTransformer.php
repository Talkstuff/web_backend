<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 15/05/2017
 * Time: 05:16 PM
 */

namespace Modules\Users\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Users\Models\User;

class UsersTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'fullName' => $user->fullName(),
            'displayName' => $user->getDisplayName(),
            'totalFriends' => $user->getTotalFriends(),
            'phone' => $user->phone,
            'email' => $user->email,
            'username' => $user->username,
            'state' => $user->state,
            'active' => $user->active,
            'country' => $user->country,
            'gender' => $user->gender,
            'birthDate' => $user->birth_date ? $user->birth_date->format('Y-m-d') : null,
            'dateRegistered' => $user->registered_date->format('Y-m-d'),
            'metadata' => $user->metadata,
            'roleIds' => $user->roles()->get()->pluck('id'),
            'groupIds' => $user->groups()->get()->pluck('id')
        ];
    }

}