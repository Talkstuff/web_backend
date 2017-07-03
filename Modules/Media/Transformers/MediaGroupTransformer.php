<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 19/05/2017
 * Time: 04:05 PM
 */

namespace Modules\Media\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Media\Models\MediaCategory;

class MediaGroupTransformer extends TransformerAbstract
{
    public function transform(MediaCategory $mediaGroup)
    {
        return [
            'id' => $mediaGroup->id,
            'name' => $mediaGroup->name,
            'type' => [
                'id' => $mediaGroup->type,
            ],
            'user' => [
                'id' => $mediaGroup->user_id,
            ],

        ];
    }

}