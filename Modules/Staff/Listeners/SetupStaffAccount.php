<?php

namespace Modules\Staff\Listeners;

use Modules\Member\Events\MemberActivated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Security\Transformers\UserProfileTransformer;
use Modules\Staff\Events\PostWasAdded;

class SetupStaffAccount
{
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
     * @param  PostWasAdded  $event
     * @return void
     */
    public function handle(PostWasAdded $event)
    {
        // todo:: setup staffs roles
        $staff = $event->staff;

        $roleIds = $event->payLoadData['roleIds'];

        $staff->roles()->sync($roleIds);
    }
}
