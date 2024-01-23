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
      
        $tableView = orderTableHTML($this->order); 
    
  
        if( $this->type == "admin" ){                                
             $this
            ->to(env('ADMIN_EMAIL'))
            ->subject($this->title)
            ->view('emails.order-admin', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order', 
                'receive'     => 'admin',         
            ]);
            
        } else if( $this->type == "agent" ){                          
             $this
            ->to($this->order->agent_email)
            ->subject($this->title)
            ->view('emails.order-agent', [
                'order'     => $this->order,           
                'tableView'     => $tableView,  
                'templateName'     => 'Order',  
                'receive'     => 'agent',       
            ]);
        }
        
        
    }
}
