<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 19/06/2017
 * Time: 04:48 PM
 */

namespace Modules\Users\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Users\Events\UserWasRegistered;
use Modules\Users\Jobs\PublishUserToWordpress;

class OnUserWasRegistered implements ShouldQueue
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
     * @param  UserWasRegistered  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        dispatch(new PublishUserToWordpress($event->user));
    }

}