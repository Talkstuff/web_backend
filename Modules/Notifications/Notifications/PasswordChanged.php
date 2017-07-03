<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Member\Models\Member;
use Modules\Notification\SMS\SmsChannel;

class PasswordChanged extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $newPassword;

    /**
     * Create a new notification instance.
     * @param $newPassword
     */
    public function __construct($newPassword)
    {
        //
        $this->newPassword = $newPassword;
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
            //SmsChannel::class
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
            ->subject('Password has been changed!')
            ->line('You successfully changed your password.')

            ->line("New Password: " . $this->newPassword)

            ->line("For further enquiries please call: 08145592020, 07052649445 or visit our website:
             http://divineleverage.bz")

            ->greeting('DLT: Empowering Lives!');
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
