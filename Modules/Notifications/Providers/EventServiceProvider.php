<?php

namespace Modules\Notifications\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Notifications\Listeners\OnPostStatusWasToggled;
use Modules\Notifications\Notifications\PostLiked;
use Modules\Posts\Events\PostStatusWasToggled;
use Modules\Users\Events\UserWasRegistered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PostStatusWasToggled::class => [
            OnPostStatusWasToggled::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
