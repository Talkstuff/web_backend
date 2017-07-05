<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Posts\Events\PostStatusWasToggled;
use Modules\Posts\Jobs\PostLikeStatusRedisNotification;
use Modules\Posts\Repositories\PostRepository;
use Modules\Posts\Transformers\PostTransformer;
use Modules\Users\Transformers\CommentTransformer;

class PostsController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * PostsController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function saveUserPost($user_id)
    {
        $post = $this->postRepository->savePost($user_id, request()->all());

        return transform($post, new PostTransformer($user_id));
    }

    public function toggleLikePost($user_id, $post_id){
        $post = $this->postRepository->findById($post_id);

        // todo:: check if user has previously liked this post
        $user = $post->userLikes()
            ->wherePivot('user_id', $user_id)
            ->first();

        $likeStatus = $user ? $user->pivot->status : false;

        $post->userLikes()->syncWithoutDetaching([$user_id => ['status' => !$likeStatus]]);

        // trigger event: PostLikeStatusWasToggled
        dispatch((new PostLikeStatusRedisNotification($post, $user_id))->onConnection('redis'));

        return transform($post, new PostTransformer($user_id));
    }

    public function makeComment($user_id, $post_id)
    {
        $comment = $this->postRepository->makePostComment($user_id, $post_id);

        return transform($comment, new CommentTransformer());

    }

    public function replyComment($user_id, $comment_id)
    {
        $comment = $this->postRepository->makeCommentOnComment($user_id, $comment_id);

        return transform($comment, new CommentTransformer());
    }
}