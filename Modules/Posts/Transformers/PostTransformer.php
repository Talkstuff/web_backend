<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 18/05/2017
 * Time: 12:09 PM
 */

namespace Modules\Posts\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Media\Transformers\MediaTransformer;
use Modules\Posts\Models\Post;
use Modules\Users\Transformers\CommentTransformer;
use Modules\Users\Transformers\UsersTransformer;

class PostTransformer extends TransformerAbstract
{
    /**
     * @var
     */
    private $user_id;

    /**
     * PostTransformer constructor.
     * @param $user_id
     */
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
    }

    public function transform(Post $post)
    {
        $isPostLiked = false;

        if($this->user_id){
            if($user = $post->userLikes()
                ->wherePivot('user_id', $this->user_id)
                ->first()){

                $isPostLiked = (boolean) $user->pivot->status;
            }
        }

        return [
            'id' => $post->id,
            'user' => [
                'id' => $post->user_id,
                'displayName' => $post->user->getDisplayName(),
                'profileMediaSource' => isset($post->user->metadata['profileMediaSource']) ?
                    $post->user->metadata['profileMediaSource'] :
                    null
            ],
            'content' => $post->content,
            'media' => transform($post->media, new MediaTransformer()),
            'postedAt' => $post->created_at->format('Y-m-d H:i:s'),
            'postedAtDiff' => $post->created_at->diffForHumans(),
            'likes' => $post->userLikes()->wherePivot('status', true)->get(),
            'liked' => $isPostLiked,
            'comments' => transform($post->comments, new CommentTransformer())
        ];
    }

}