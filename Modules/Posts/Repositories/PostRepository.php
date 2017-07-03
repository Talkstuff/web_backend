<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 11/05/2017
 * Time: 10:55 AM
 */

namespace Modules\Posts\Repositories;


use Modules\Media\Repositories\MediaRepository;
use Modules\Posts\Events\PostWasAdded;
use Modules\Posts\Models\Post;
use Modules\Users\Repositories\CommentRepository;

class PostRepository
{
    /**
     * @var Post
     */
    private $post;

    /**
     * PostRepository constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function savePost($user_id, array $payLoad){
        $postData = $payLoad['post'];

        // we are editing a post if we supply the post's id
        $editMode = isset($postData['id']) ? true : false;

        /**
         * @var Post $post
         */
        $post = $this->post->firstOrNew([
            'id' => $editMode ? $postData['id'] : null
        ]);

        $post->fill([
            'user_id' => $user_id,
            'content' => $postData['content'],
        ]);

        $post->save();

        if($payLoad['videoUrl']){
            /**
             * @var MediaRepository $mediaRepo
             */
            $mediaRepo = app(MediaRepository::class);
            $videoMedia = $mediaRepo->saveVideo($user_id, $payLoad['videoUrl']);
            $postData['mediaAttachments'][] = $videoMedia->id;
        }

        // attach image media
        if(count($postData['mediaAttachments'])) $post->media()->sync($postData['mediaAttachments']);

        // fire an event when creating a new post
        if(!$editMode) event(new PostWasAdded($post, $postData));

        return $post;
    }

    /**
     * @param $post_id
     * @return Post
     */
    public function findById($post_id)
    {
        return $this->post->find($post_id);
    }

    public function makePostComment($user_id, $post_id)
    {
        $post = $this->findById($post_id);

        $comment = $post->comments()->create([
            'comment' => \request()->get('comment'),
            'user_id' => $user_id
        ]);

        // todo:: fire event: CommentWasMade

        return $comment;
    }

    public function makeCommentOnComment($user_id, $comment_id)
    {
        /**
         * @var CommentRepository $commentRepo
         */
        $commentRepo = app(CommentRepository::class);

        $comment = $commentRepo->findById($comment_id);

        $repliedComment = $comment->comments()->create([
            'comment' => \request()->get('comment'),
            'user_id' => $user_id
        ]);

        // todo:: fire event: CommentWasMade

        return $repliedComment;
    }
}