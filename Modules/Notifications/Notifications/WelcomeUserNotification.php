<?php

namespace Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Member\Models\Member;
use Modules\Notification\SMS\SmsChannel;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct()
    {
        //
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
            ->subject('Welcome to talkstuff.com')
            ->greeting("Hello, $notifiable->username!")
            ->line('Welcome to the #1 social media platform in Nigeria, where you can connect with friends, family and loved ones worldwide, boost your business and marketing campaign and lots more goodies....')

            ->line('Here is your login detail:')
            ->line("Username: " . $notifiable->username)

            ;


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
