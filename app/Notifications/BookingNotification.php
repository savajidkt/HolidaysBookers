<?php

namespace App\Notifications;

use App\Mail\BookingMail;
use App\Models\User;
use App\Mail\ContactMail;
use App\Mail\RegisterdMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingNotification extends Notification
{
    use Queueable;

    protected $order;    
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $type)
    {  
        $this->order = $order;
        $this->type = $type;
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
        return new BookingMail($this->order,$this->type);
    }
}
