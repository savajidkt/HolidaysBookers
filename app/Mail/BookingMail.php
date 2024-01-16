<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;    
    protected $type;
    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$type)
    {
       
         $this->order = $order;
         $this->type = $type;
        // $this->contactNumber = $contactNumber;
        // $this->message = $message;
         $this->title        = 'Booking Request from Holidays Bookers';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
       
        if( $this->type == "admin" ){           
            return $this
            ->to(env('ADMIN_EMAIL'))
            ->subject($this->title)
            ->view('emails.order-admin', [
                'order_id'     => $this->order->id              
            ]);
            
        } else if( $this->type == "agent" ){          
            return $this
            ->to($this->order->agent_email)
            ->subject($this->title)
            ->view('emails.order-agent', [
                'order_id'     => $this->order->id             
            ]);
        }
        
    }
}
