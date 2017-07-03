<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Member\Models\Member;
use Modules\Notification\SMS\SmsChannel;

class MemberHasCompletedStage extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
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
        $completedStage = config('dltgold.stages')[$notifiable->stage_id - 1];

        $mail = (new MailMessage)
            ->success()
            ->subject('DLT Alert: Stage Completion')
            ->greeting("Hi, $notifiable->firstName," )
        ;

        // todo:: if completed stage is ordinary
        if(($notifiable->stage_id - 1) == 1){
            $mail
            ->line('You have successfully completed the feeder stage. You are now a BRONZE member in DLT Gold')
                ;
        } else {
            // todo:: completed stage is above ordinary
            $mail
                ->line("You have successfully completed " . $completedStage['name'])
                ->line('You are automatically placed on a one year medical cover with an access to DLT Soft loans.')
                ->line('You are qualified for the following incentives')
                ->line($completedStage['award'])
                ;
        }

        return $mail
            ->line("For further enquiries please call: 08145592020, 07052649445 or visit our website:
             http://divineleverage.bz")

            ->greeting('DLT: Empowering Lives!');
    }

    public function toSms($notifiable)
    {
        // todo:: if completed stage is ordinary
        if(($notifiable->stage_id - 1) == 1){
            $message = 'Hi ' . $notifiable->firstName . '. U hv successfully completed d feedr stage.' .
            ' u are now a BRONZE member on DLT Gold.';
        } else {
            // todo:: completed stage is above ordinary
            $message = "Hi $notifiable->firstName, u are now in " . config($notifiable->stage_id)['name']
            . '. pls check ur email for further info.'
            ;
        }
        $sms = [
            'sender' => 'DLT ALERT',
            'recipients' => $notifiable->phone,
            'message' => $message,
        ];

        return $sms;
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
