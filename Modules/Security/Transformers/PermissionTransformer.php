<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 07/06/2017
 * Time: 03:34 PM
 */

namespace Modules\Security\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Security\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
            'description' => $permission->description,
        ];
    }

}