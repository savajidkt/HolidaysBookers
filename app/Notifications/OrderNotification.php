<?php

namespace App\Notifications;

use App\Models\User;
use App\Mail\OrderMail;
use App\Mail\RegisterdMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderNotification extends Notification
{
    use Queueable;

    protected $agentCode;
    protected $email;        
    protected $attachment_path;        

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $filePath)
    {        
        $this->agentCode = $order->agent_code;
        $this->email = $order->agent_email;
        $this->attachment_path = $filePath;
        
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
        return new OrderMail($this->agentCode, $this->email, $this->attachment_path);
    }
}
