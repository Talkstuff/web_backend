<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 07/06/2017
 * Time: 03:34 PM
 */

namespace Modules\Security\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Security\Models\PermissionCategory;

class PermissionCategoryTransformer extends TransformerAbstract
{
    public function transform(PermissionCategory $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'reserved' => $category->reserved

        ];
    }

}