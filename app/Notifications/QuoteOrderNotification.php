<?php

namespace App\Notifications;

use App\Models\User;
use App\Mail\ContactMail;
use App\Mail\QuoteMail;
use App\Mail\RegisterdMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuoteOrderNotification extends Notification
{
    use Queueable;
    protected $QuoteOrder;       
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($param)
    {        
        $this->QuoteOrder = $param;    
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {        
        return new QuoteMail($this->QuoteOrder);
    }
}
