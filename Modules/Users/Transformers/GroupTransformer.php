<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 21/06/2017
 * Time: 05:49 PM
 */

namespace Modules\Users\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Users\Models\Group;

class GroupTransformer extends TransformerAbstract
{
    public function transform(Group $group)
    {
        return [
            'id' => $group->id,
            'name' => $group->name,
            'user_id' => $group->user_id,
            'reserved' => $group->reserved
        ];
    }

}