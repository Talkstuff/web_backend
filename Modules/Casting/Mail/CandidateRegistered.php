<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 15/06/2017
 * Time: 03:17 PM
 */

namespace Modules\Casting\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Modules\Casting\Models\Cast;
use Modules\Users\Models\User;

class CandidateRegistered extends Mailable
{

    use Queueable, SerializesModels;
    /**
     * @var Cast
     */
    public $cast;

    /**
     * Create a new message instance.
     *
     * @param Cast $cast
     */
    public function __construct(Cast $cast)
    {
        //
        $this->cast = $cast;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->cast->email)
            ->subject('Your audition has been received!')
            ->view('emails.candidate-registered');
    }
}