<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 21/11/2016
 * Time: 11:41 AM
 */

namespace Modules\Staff\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Branch\Transformers\BranchTransformer;
use Modules\Security\Transformers\RolesTransformer;
use Modules\Staff\Models\Staff;

class StaffTransformer extends TransformerAbstract
{
    public function transform(Staff $staff){
        return [
            'id' => $staff->id,
            'firstName' => $staff->firstName,
            'lastName' => $staff->lastName,
            'otherNames' => $staff->otherNames,
            'fullName' => $staff->fullName(),

            'username' => $staff->username,
            'email' => $staff->email,

            'roleIds' => $staff->user ? $staff->roles->pluck('id') : [],

            'roles' => transform($staff->roles, new RolesTransformer()),

            'permissions' => [],

            'phone' => $staff->phone,

            'active' => $staff->active,
        ];
    }

}