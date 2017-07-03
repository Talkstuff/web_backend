<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Member\Models\Member;
use Modules\Member\Models\Transaction;
use Modules\Notification\SMS\SmsChannel;

class CreditAlertNotification extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $transaction;

    /**
     * Create a new notification instance.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction = $transaction;
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
            ->subject('Credit Alert!')
            ->line('You have been credited with N' .
                $this->transaction->amount .
                ' on your e-wallet account on the DLT Gold platform.')

            ->line('Please login to your account for details.')

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
