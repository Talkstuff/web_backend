<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 15/06/2017
 * Time: 03:17 PM
 */

namespace Modules\Security\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Modules\Users\Models\User;

class ForgotPassword extends Mailable
{

    use Queueable, SerializesModels;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // todo:: generate and attach unique key
        $encrption = $this->user->setRequestEncryption();
        $this->user->setEncryptionExpiration();

        return $this
            ->to($this->user->email)
            ->view('emails.forgot-password')
            ->with('encryption', $encrption);
    }
}