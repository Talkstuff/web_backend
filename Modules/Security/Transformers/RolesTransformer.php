<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 22/11/2016
 * Time: 10:42 AM
 */

namespace Modules\Security\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Security\Models\Role;


class RolesTransformer extends TransformerAbstract
{

    public function transform(Role $role){
        return [
            'id' => $role->id,
            'name' => $role->name,
            'description' => $role->description,
            'permissions' => $role->permissions
        ];
    }

}