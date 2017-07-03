<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 11/05/2017
 * Time: 12:19 PM
 */

namespace Modules\Users\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Security\Transformers\RolesTransformer;
use Modules\Staff\Models\Staff;
use Modules\Users\Models\User;

class AdminUserProfileTransformer extends TransformerAbstract
{
    public function transform(User $user){
        return [
            'id' => $user->id,
            'fullName' => $user->fullName(),
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'active' => $user->active,
            'roles'  => transform($user->roles, new RolesTransformer()),
            'permissions' => $user->allPermissions(),
        ];
    }

}