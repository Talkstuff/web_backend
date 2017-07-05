<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 19/06/2017
 * Time: 04:48 PM
 */

namespace Modules\Notifications\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Notifications\Notifications\PostLiked;
use Modules\Posts\Events\PostStatusWasToggled;
use Modules\Users\Events\UserWasRegistered;
use Modules\Users\Jobs\PublishUserToWordpress;
use Modules\Users\Models\User;
use Modules\Users\Repositories\UsersRepository;

class OnPostStatusWasToggled implements ShouldQueue
{
    public $connection = 'redis';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostStatusWasToggled  $event
     * @return void
     */
    public function handle(PostStatusWasToggled $event)
    {
        $post = $event->post;

        /**
         * @var User $user
         */
        $user = $post->userLikes()
            ->wherePivot('user_id', $event->user_id)
            ->first();

        // notify the owner of this post that the user (of user_id) has liked his post (if post-like status is true)
        if($user->pivot->status){
            $post->user->notify(new PostLiked($post, $user));
        }
    }

}