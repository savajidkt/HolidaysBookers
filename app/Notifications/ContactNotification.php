<?php

namespace App\Notifications;

use App\Models\User;
use App\Mail\ContactMail;
use App\Mail\RegisterdMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactNotification extends Notification
{
    use Queueable;

    protected $fullname;
    protected $email;
    protected $contactNumber;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $param)
    {        
        $this->fullname = $param['name'];
        $this->email = $param['email'];
        $this->contactNumber = $param['phone'];
        $this->message = $param['message'];  
        
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
        return new ContactMail($this->fullname,$this->email, $this->contactNumber, $this->message);
    }
}
