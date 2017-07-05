<?php

namespace Modules\Posts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Modules\Posts\Events\PostStatusWasToggled;
use Modules\Posts\Models\Post;

class PostLikeStatusRedisNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Post
     */
    private $post;
    /**
     * @var
     */
    private $user_id;

    /**
     * Create a new job instance.
     *
     * @param Post $post
     * @param $user_id
     */
    public function __construct(Post $post, $user_id)
    {
        //
        $this->post = $post;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('post like event is being fired...');
        event(new PostStatusWasToggled($this->post, $this->user_id));
    }
}
