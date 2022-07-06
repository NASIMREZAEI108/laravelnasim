<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\GhasedakChannel;

class ActiveCodeNotification extends Notification
{
    use Queueable;

    public $code;

    public $phoneNumber;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code , $phoneNumber)
    {
      $this->code = $code;
      $this->phoneNumber = $phoneNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [GhasedakChannel::class];
    }


    public function toGhasedakSms($notifiable)
    {
      return[
          'text' => "وبسایت نسیم{$this->code} \n کد احرازهویت",
          'number' => $this->phoneNumber
        ];
    }
  
}
