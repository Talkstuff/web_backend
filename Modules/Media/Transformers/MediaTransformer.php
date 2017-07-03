<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 19/05/2017
 * Time: 04:03 PM
 */

namespace Modules\Media\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Media\Models\Media;

class MediaTransformer extends TransformerAbstract
{
    public function transform(Media $media)
    {
        return [
            'id' => $media->id,
            'source' => $media->source,
            'blocked' => $media->blocked,
            'privacy' => $media->getPrivacy(),
            'featured' => $media->featured,
            'metadata' => $media->metadata,
            'downloads' => $media->downloads,
            'type' => $media->getMediaType(),
        ];
    }

}