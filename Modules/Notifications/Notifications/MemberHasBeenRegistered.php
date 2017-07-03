<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Member\Models\Member;
use Modules\Notification\SMS\SmsChannel;

class MemberHasBeenRegistered extends Notification
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
            SmsChannel::class
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
            ->subject('Welcome to DLT Gold')
            ->greeting("Congratulations!")
            ->line('You have been successfully registered on the DLT Gold platform')
            ->line("Start earning money immediately as you refer people using your link.")
            ->line("Referral Link: " . $notifiable->getReferralLink())
            ->line("Username: " . $notifiable->getMemberUsername())
            ->line("Password: " . $notifiable->getMemberUsername() . '123')

            ->line("For further enquiries please call: 08145592020, 07052649445 or visit our website:
             http://divineleverage.bz")

            ->greeting('DLT: Empowering Lives!');
    }

    public function toSms($notifiable)
    {
        //instantiate welcome sms
        $username = $notifiable->getMemberUsername();
        $password = $username . '123';
        return [
            'sender' => 'DLT',
            'recipients' => $notifiable->phone,
            'message' => 'Welcome, ' . $notifiable->firstName .
                ' to DLT. The fastest growing MSM in Africa. You can login with: ' .
                "username: " .  $username .
                ", pwd: " .  $password .
                '. Call 07052649445 for more info. divineleverage.bz',
        ];
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
