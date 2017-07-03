<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Member\Models\Member;
use Modules\Notification\SMS\SmsChannel;

class MemberHasRequestedForCash extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $amount;

    /**
     * Create a new notification instance.
     * @param $amount
     */
    public function  __construct($amount)
    {
        //
        $this->amount = $amount;
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
            ->subject('Cash Request')
            ->greeting("Hi, $notifiable->firstName," )
            ->line("Your request for N$this->amount is being processed.")
            ->line("You will be credited within 4 hours of working days.")

            ->line("For further enquiries please call: 08145592020, 07052649445 or visit our website:
             http://divineleverage.bz")

            ->greeting('DLT: Empowering Lives!');
    }

    public function toSms($notifiable)
    {
        return [
            'sender' => 'DLT ALERT',
            'recipients' => $notifiable->phone,
            'message' => 'Hi, ' . $notifiable->firstName .
                ' ur request 4 N' . $this->amount .
            " is being processed. U'll be credited within 4hrs of working days. ".
                'Call 07052649445 for more info. divineleverage.bz',
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
