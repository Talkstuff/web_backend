<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/25/2017
 * Time: 5:13 PM
 */

namespace Modules\Media\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Media\Models\MediaComment;

class MediaCommentsTransformer extends TransformerAbstract
{
    public function transform(MediaComment $mediaComment)
    {
        return [
            'id' => $mediaComment->id,
            'media' => $mediaComment->media_id,
            'blocked' => $mediaComment->blocked,
            'sentBy' => $mediaComment->sender_id,
            'msg' => $mediaComment->comment,
        ];
    }

}