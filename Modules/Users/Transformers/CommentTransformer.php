<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 23/05/2017
 * Time: 01:47 PM
 */

namespace Modules\Users\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Users\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'user' => [
                'id' => $comment->user->id,
                'displayName' => $comment->user->getDisplayName(),
                'metadata' => $comment->user->metadata
            ],
            'comments' => transform($comment->comments, new self()),
            'date' => $comment->created_at->format('Y-m-d h:i:s')
        ];
    }

}