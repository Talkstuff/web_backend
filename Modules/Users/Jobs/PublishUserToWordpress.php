<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 19/06/2017
 * Time: 04:38 PM
 */

namespace Modules\Users\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Casting\Repositories\CastingRepository;
use Modules\Users\Models\User;

class PublishUserToWordpress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param CastingRepository $castingRepository
     * @return void
     */
    public function handle(CastingRepository $castingRepository)
    {
        $castingRepository->toWordpress($this->user);
    }

}