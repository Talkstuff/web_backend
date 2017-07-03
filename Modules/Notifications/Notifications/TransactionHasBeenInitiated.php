<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notification\SMS\SmsChannel;

class TransactionHasBeenInitiated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
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
        return ['mail', SmsChannel::class];
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
            ->subject('Your account is activated')
            ->greeting("Congratulations!")
            ->line('Your account is now active on the DLT platform.')
            ->line("Start earning money immediately as you refer people using your link.")
            ->line("Referral Link: " . $notifiable->getReferralLink())
            ->line("Username: " . $notifiable->getMemberUsername())
            ->line("Transaction pin: " . $notifiable->getTransactionPin())

            ->line("For further enquiries please call: 08145592020, 07052649445 or visit our website:
             http://divineleverage.bz")

            ->greeting('DLT: Empowering Lives!');
    }

    public function toSms($notifiable)
    {
        //instantiate welcome sms
        return [
            'sender' => 'DLT',
            'recipients' => $notifiable->phone,
            'message' => 'Welcome, ' . $notifiable->otherNames .
                ' to DLT. The fastest growing network in Africa. You can login as: ' .
                "username: " .  $notifiable->username .
                ", password: " .  $notifiable->usename . '123' .
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
