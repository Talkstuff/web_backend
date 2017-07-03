<?php

namespace Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Posts\Models\Post;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $connection = 'redis';

    /**
     * @var
     */
    private $post;

    /**
     * Create a new notification instance.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        //
        $this->post = $post;
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
        return (new MailMessage)
            ->success()
            ->subject($this->post->user->fullName() . ' make a new post')

            ->line('Please login to find out on latest feeds.')

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
