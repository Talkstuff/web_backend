<?php

namespace Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Modules\Posts\Models\Post;
use Modules\Users\Models\User;

class PostLiked extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var
     */
    private $post;
    /**
     * @var User
     */
    private $liker;

    /**
     * Create a new notification instance.
     * @param Post $post
     * @param User $liker
     */
    public function __construct(Post $post, User $liker)
    {
        //
        $this->post = $post;
        $this->liker = $liker;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'mail',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::info('should be sending mail now....');
        return (new MailMessage)
            ->success()

            ->subject($this->liker->fullName() . ' liked your status')

            ->greeting('Hi ' . $notifiable->getDisplayName())

            ->line($this->liker->fullName() . ' liked your status. Please login to find out on latest feeds.')

            ->action('Sign in','https://talkstuff.com/security/login')
            ;
    }

    public function toSms($notifiable)
    {
        /*return [
            'sender' => 'DLT',
            'recipients' => $notifiable->phone,
            'message' => 'Hi, ' . $notifiable->firstName .
                ' u are now LIVE on DLT-Gold' .
                ", transactPin: " .  $notifiable->getTransactionPin() .
                ", referral link: " .  $notifiable->getReferralLink() .
                '. Call 07052649445 for more info. divineleverage.bz',
        ];*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
